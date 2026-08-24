<?php

namespace App\Services;

use App\Services\Payment\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PagBankService implements PaymentGatewayInterface
{
    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $sandbox = config('services.pagbank.sandbox', true);
        $this->baseUrl = $sandbox
            ? 'https://sandbox.api.pagseguro.com'
            : 'https://api.pagseguro.com';
        $this->token = config('services.pagbank.token');
    }

    public function getName(): string
    {
        return 'pagbank';
    }

    public function createPixPayment(array $data): array
    {
        $amountCents = (int) round((float) $data['amount'] * 100);
        $phone = preg_replace('/\D/', '', $data['phone'] ?? '');
        $area = substr($phone, 0, 2);
        $number = substr($phone, 2);

        $response = Http::withToken($this->token)
            ->withHeaders(['x-idempotency-key' => (string) Str::uuid()])
            ->post("{$this->baseUrl}/orders", [
                'reference_id' => $data['booking_uuid'],
                'customer' => [
                    'name' => trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')),
                    'email' => $data['email'],
                    'tax_id' => preg_replace('/\D/', '', $data['cpf']),
                    'phones' => [
                        ['country' => '55', 'area' => $area, 'number' => $number, 'type' => 'MOBILE'],
                    ],
                ],
                'items' => [
                    [
                        'reference_id' => $data['booking_uuid'],
                        'name' => $data['description'],
                        'quantity' => 1,
                        'unit_amount' => $amountCents,
                    ],
                ],
                'qr_codes' => [
                    [
                        'amount' => ['value' => (string) $amountCents],
                        'expiration_date' => now()->addMinutes(30)->format('Y-m-d\TH:i:s-03:00'),
                    ],
                ],
                'notification_urls' => [config('services.pagbank.webhook_url', route('webhook.pagbank'))],
            ]);

        if (!$response->successful()) {
            Log::error('PagBank PIX: falha ao criar pedido', ['response' => $response->json()]);
            return ['success' => false, 'message' => 'Não foi possível gerar o PIX.', 'data' => $response->json()];
        }

        $json = $response->json();
        $qrText = $json['qr_codes'][0]['text'] ?? null;
        $qrBase64 = $qrText ? base64_encode(QrCode::format('png')->size(300)->generate($qrText)) : null;

        return [
            'success' => true,
            'data' => [
                'order_id' => $json['id'],
                'qr_code' => $qrText,
                'qr_code_base64' => $qrBase64,
                'status' => 'waiting',
            ],
        ];
    }

    public function createCardPayment(array $data): array
    {
        $amountCents = (int) round((float) $data['amount'] * 100);
        $phone = preg_replace('/\D/', '', $data['phone'] ?? '');
        $area = substr($phone, 0, 2);
        $number = substr($phone, 2);

        $response = Http::withToken($this->token)
            ->withHeaders(['x-idempotency-key' => (string) Str::uuid()])
            ->post("{$this->baseUrl}/orders", [
                'reference_id' => $data['booking_uuid'],
                'customer' => [
                    'name' => trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')),
                    'email' => $data['email'],
                    'tax_id' => preg_replace('/\D/', '', $data['cpf']),
                    'phones' => [
                        ['country' => '55', 'area' => $area, 'number' => $number, 'type' => 'MOBILE'],
                    ],
                ],
                'items' => [
                    [
                        'reference_id' => $data['booking_uuid'],
                        'name' => $data['description'],
                        'quantity' => 1,
                        'unit_amount' => $amountCents,
                    ],
                ],
                'notification_urls' => [config('services.pagbank.webhook_url', route('webhook.pagbank'))],
                'charges' => [
                    [
                        'reference_id' => $data['booking_uuid'],
                        'description' => $data['description'],
                        'amount' => ['value' => $amountCents, 'currency' => 'BRL'],
                        'payment_method' => [
                            'type' => 'CREDIT_CARD',
                            'installments' => (int) ($data['installments'] ?? 1),
                            'capture' => true,
                            'card' => [
                                'encrypted' => $data['card_encrypted'],
                                'store' => false,
                            ],
                            'holder' => [
                                'name' => trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')),
                                'tax_id' => preg_replace('/\D/', '', $data['cpf']),
                            ],
                        ],
                    ],
                ],
            ]);

        if (!$response->successful()) {
            Log::error('PagBank Cartão: falha ao criar pedido', ['response' => $response->json()]);
            return ['success' => false, 'message' => $this->getCardErrorMessage($response->json()), 'data' => $response->json()];
        }

        $json = $response->json();
        $charge = $json['charges'][0] ?? [];
        $status = strtolower($charge['status'] ?? 'waiting');

        if (in_array($status, ['declined', 'canceled'], true)) {
            return [
                'success' => false,
                'message' => $this->getCardErrorMessage($json),
                'data' => $json,
            ];
        }

        return [
            'success' => true,
            'data' => [
                'order_id' => $json['id'],
                'charge_id' => $charge['id'] ?? null,
                'status' => $status,
            ],
        ];
    }

    public function getPayment(string $paymentId): array
    {
        $response = Http::withToken($this->token)
            ->get("{$this->baseUrl}/orders/{$paymentId}");

        return $response->json();
    }

    public function getCardErrorMessage(array $payment): string
    {
        $charge = $payment['charges'][0] ?? $payment;
        $message = $charge['payment_response']['message']
            ?? $payment['error_messages'][0]
            ?? null;

        return $message ?? 'Pagamento recusado. Verifique os dados do cartão e tente novamente.';
    }

    public function refundPayment(string $paymentId, ?float $amount = null): array
    {
        $payload = [];

        if ($amount !== null) {
            $payload['amount'] = (int) round($amount * 100);
        }

        $response = Http::withToken($this->token)
            ->withHeaders(['x-idempotency-key' => (string) Str::uuid()])
            ->post("{$this->baseUrl}/orders/{$paymentId}/refunds", $payload);

        if (!$response->successful()) {
            Log::error('PagBank: falha ao estornar', ['payment_id' => $paymentId, 'response' => $response->json()]);
            return ['success' => false, 'message' => 'Não foi possível estornar.', 'data' => $response->json()];
        }

        return ['success' => true, 'data' => $response->json()];
    }
}
