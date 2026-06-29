<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MercadoPagoService
{
    protected string $baseUrl = 'https://api.mercadopago.com';
    protected string $accessToken;

    public function __construct()
    {
        $this->accessToken = config('services.mercadopago.access_token');
    }

    // ─────────────────────────────────────────
    // PIX
    // ─────────────────────────────────────────
    public function createPixPayment(array $data): array
    {
        $response = Http::withToken($this->accessToken)
            ->withHeaders([
                'X-Idempotency-Key' => (string) Str::uuid(),
            ])
            ->post("{$this->baseUrl}/v1/payments", [
                'transaction_amount' => $data['amount'],
                'description'        => $data['description'],
                'payment_method_id'  => 'pix',

                'payer' => [
                    'email'      => $data['email'],
                    'first_name' => $data['first_name'],
                    'last_name'  => $data['last_name'],
                    'identification' => [
                        'type'   => 'CPF',
                        'number' => preg_replace('/\D/', '', $data['cpf']),
                    ],
                ],

                'notification_url'   => config('services.mercadopago.webhook_url', route('webhook.mercadopago')),
                'external_reference' => $data['booking_uuid'],
                'date_of_expiration' => now()->addMinutes(30)->format('Y-m-d\TH:i:s.000-03:00'),
            ]);

        return $response->json();
    }

    // ─────────────────────────────────────────
    // CARTÃO DE CRÉDITO
    // ─────────────────────────────────────────
    public function createCardPayment(array $data): array
    {
        $response = Http::withToken($this->accessToken)
            ->withHeaders(['X-Idempotency-Key' => (string) Str::uuid()])
            ->post("{$this->baseUrl}/v1/payments", [
                'transaction_amount'  => $data['amount'],
                'description'         => $data['description'],
                'payment_method_id'   => $data['payment_method_id'],
                'token'               => $data['card_token'],
                'installments'        => $data['installments'] ?? 1,
                'payer' => [
                    'email'          => $data['email'],
                    'identification' => [
                        'type'   => 'CPF',
                        'number' => preg_replace('/\D/', '', $data['cpf']),
                    ],
                ],
                'notification_url'   => route('webhook.mercadopago'),
                'external_reference' => $data['booking_uuid'],
            ]);

        return $response->json();
    }

    // ─────────────────────────────────────────
    // CONSULTAR PAGAMENTO
    // ─────────────────────────────────────────
    public function getPayment(string $paymentId): array
    {
        $response = Http::withToken($this->accessToken)
            ->get("{$this->baseUrl}/v1/payments/{$paymentId}");

        return $response->json();
    }
}