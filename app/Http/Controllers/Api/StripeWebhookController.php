<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request, StripeService $stripe)
    {
        try {
            $event = $stripe->constructWebhookEvent(
                $request->getContent(),
                $request->header('Stripe-Signature'),
                config('services.stripe.webhook_secret')
            );
        } catch (\Exception $e) {
            Log::error('Stripe webhook signature inválida', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'invalid signature'], 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;
            $bookingUuid = $intent->metadata->booking_uuid ?? null;

            $booking = Booking::where('uuid', $bookingUuid)->first();

            if ($booking && $booking->payment_status !== PaymentStatusEnum::PAID) {
                $booking->update([
                    'status' => BookingStatusEnum::CONFIRMED,
                    'payment_status' => PaymentStatusEnum::PAID,
                    'paid_at' => now(),
                ]);
                app(\App\Services\Booking\BookingPaidService::class)->handle($booking->fresh());
            }
        }

        return response()->json(['ok' => true]);
    }
}
