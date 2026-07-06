<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\PagHiperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PagHiperWebhookController extends Controller
{
    public function handle(Request $request, PagHiperService $paghiper)
    {
        $apiKey = $request->input('apiKey');
        $notificationId = $request->input('notification_id');

        if (!$apiKey || !$notificationId) {
            return response()->json(['ok' => true]); // ignora silenciosamente
        }

        $details = $paghiper->confirmNotification($apiKey, $notificationId);

        $orderId = $details['order_id'] ?? null;
        $status = $details['status'] ?? null;

        $booking = Booking::where('uuid', $orderId)->first();

        if ($booking && $status === 'paid' && $booking->payment_status !== PaymentStatusEnum::PAID) {
            $booking->update([
                'status' => BookingStatusEnum::CONFIRMED,
                'payment_status' => PaymentStatusEnum::PAID,
                'paid_at' => now(),
            ]);
            app(\App\Services\Booking\BookingPaidService::class)->handle($booking->fresh());
        }

        return response()->json(['ok' => true]);
    }
}
