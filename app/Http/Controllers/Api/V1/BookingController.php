<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\TourDateStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\TourDate;
use App\Services\Booking\BookingCancellationService;
use App\Services\Booking\BookingPaidService;
use App\Services\PagBankService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = $request->user()
            ->bookings()
            ->with(['tour', 'tourDate'])
            ->latest()
            ->paginate(10);

        return BookingResource::collection($bookings);
    }

    public function show(Request $request, $uuid)
    {
        $booking = $request->user()
            ->bookings()
            ->where('uuid', $uuid)
            ->with(['tour', 'tourDate'])
            ->firstOrFail();

        return new BookingResource($booking);
    }

    public function store(Request $request, PagBankService $pagBank, BookingPaidService $bookingPaidService)
    {
        $validated = $request->validate([
            'tour_date_id'  => ['required', 'exists:tour_dates,id'],
            'adults'        => ['required', 'integer', 'min:1'],
            'children'      => ['sometimes', 'integer', 'min:0'],
            'children_free' => ['sometimes', 'integer', 'min:0'],
            'payment_method' => ['required', 'in:pix,credit_card'],
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email'],
            'cpf'           => ['required', 'string', 'max:20'],
            'phone'         => ['required', 'string', 'max:20'],
            'card_encrypted' => ['required_if:payment_method,credit_card', 'string'],
            'installments'  => ['sometimes', 'integer', 'min:1', 'max:12'],
        ]);

        $tourDate = TourDate::with('tour.company')->findOrFail($validated['tour_date_id']);

        $people = $validated['adults'] + ($validated['children'] ?? 0) + ($validated['children_free'] ?? 0);

        if ($tourDate->status !== TourDateStatusEnum::OPEN
            || $tourDate->date->isPast()
            || $tourDate->remaining_available < $people) {
            return response()->json(['message' => 'Não há vagas disponíveis para esta data.'], 422);
        }

        $priceAdult = (float) $tourDate->price;
        $priceChildren = (float) ($tourDate->half_price ?? $priceAdult / 2);
        $subtotal = ($validated['adults'] * $priceAdult) + (($validated['children'] ?? 0) * $priceChildren);
        $commissionPct = (float) $tourDate->tour->company->commission_rate;
        $commissionAmount = round($subtotal * ($commissionPct / 100), 2);
        $companyAmount = $subtotal - $commissionAmount;
        $total = $subtotal;

        $customer = $request->user();

        if (!$customer) {
            $customer = Customer::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'name' => $validated['name'],
                    'phone' => preg_replace('/\D/', '', $validated['phone']),
                    'cpf' => preg_replace('/\D/', '', $validated['cpf']),
                    'password' => Hash::make(Str::random(16)),
                    'status' => true,
                ]
            );

            if (!$customer->hasRole('client')) {
                $customer->assignRole('client');
            }
        }

        $booking = Booking::create([
            'uuid' => (string) Str::uuid(),
            'tour_id' => $tourDate->tour_id,
            'company_id' => $tourDate->tour->company_id,
            'customer_id' => $customer->id,
            'tour_date_id' => $tourDate->id,
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'customer_phone' => preg_replace('/\D/', '', $customer->phone ?? $validated['phone']),
            'adults' => $validated['adults'],
            'children' => $validated['children'] ?? 0,
            'children_free' => $validated['children_free'] ?? 0,
            'payment_method' => $validated['payment_method'],
            'gateway' => 'pagbank',
            'subtotal' => $subtotal,
            'commission_amount' => $commissionAmount,
            'company_amount' => $companyAmount,
            'total' => $total,
            'status' => BookingStatusEnum::PENDING,
            'payment_status' => PaymentStatusEnum::PENDING,
            'expires_at' => now()->addMinutes(30),
        ]);

        $nameParts = explode(' ', trim($customer->name), 2);
        $paymentData = [
            'amount' => $total,
            'description' => "Passeio: {$tourDate->tour->title}",
            'email' => $customer->email,
            'first_name' => $nameParts[0],
            'last_name' => $nameParts[1] ?? '',
            'cpf' => $customer->cpf ?? $validated['cpf'],
            'phone' => $customer->phone ?? $validated['phone'],
            'booking_uuid' => $booking->uuid,
        ];

        if ($validated['payment_method'] === 'pix') {
            $response = $pagBank->createPixPayment($paymentData);
        } else {
            $response = $pagBank->createCardPayment(array_merge($paymentData, [
                'card_encrypted' => $validated['card_encrypted'],
                'installments' => $validated['installments'] ?? 1,
            ]));
        }

        if (!$response['success']) {
            return response()->json([
                'message' => $response['message'] ?? 'Não foi possível iniciar o pagamento.',
            ], 422);
        }

        $booking->update(['payment_id' => $response['data']['order_id']]);

        $payment = $response['data'];

        if ($validated['payment_method'] === 'credit_card' && ($payment['status'] ?? null) === 'paid') {
            $bookingPaidService->handle($booking->fresh());
        }

        return response()->json([
            'booking' => new BookingResource($booking->load(['tour', 'tourDate'])),
            'payment' => [
                'method' => $validated['payment_method'],
                'status' => $payment['status'],
                'order_id' => $payment['order_id'],
                'qr_code' => $payment['qr_code'] ?? null,
                'qr_code_base64' => $payment['qr_code_base64'] ?? null,
            ],
        ], 201);
    }

    public function cancel(Request $request, $uuid, BookingCancellationService $cancellationService)
    {
        $booking = $request->user()
            ->bookings()
            ->where('uuid', $uuid)
            ->firstOrFail();

        if ($booking->status === BookingStatusEnum::CANCELLED) {
            return response()->json(['message' => 'Esta reserva já foi cancelada.'], 422);
        }

        if (in_array($booking->status, [BookingStatusEnum::CONFIRMED, BookingStatusEnum::PENDING], true)
            && $booking->tourDate->date->isPast()) {
            return response()->json(['message' => 'Não é possível cancelar um passeio já realizado.'], 422);
        }

        $cancellationService->handle($booking, $request->input('reason'));

        return new BookingResource($booking->fresh()->load(['tour', 'tourDate']));
    }
}
