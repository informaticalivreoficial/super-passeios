<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MercadoPagoService
{
    protected string $baseUrl = 'https://api.mercadopago.com';
    protected string $accessToken;

    protected const MP_ERRORS = [
        205 => 'Informe o número do cartão.',
        208 => 'Informe o mês de validade.',
        209 => 'Informe o ano de validade.',
        212 => 'Informe o documento do titular.',
        213 => 'Informe o CPF do titular.',
        214 => 'Informe o CPF do titular.',
        220 => 'Informe o banco emissor.',

        2131 => 'Não foi possível identificar a bandeira do cartão.',

        3000 => 'O cartão informado é inválido.',
        3001 => 'O cartão está vencido.',
        3002 => 'O código de segurança é inválido.',
        3003 => 'O pagamento foi recusado pela operadora.',
    ];

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

        return $this->formatResponse($response);
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

        return $this->formatResponse($response);
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

    protected function getErrorMessage(array $response): string
    {
        $cause = $response['cause'][0] ?? [];

        $code = $cause['code'] ?? null;

        return self::MP_ERRORS[$code]
            ?? 'Não foi possível processar o pagamento. Tente novamente.';
    }

    public function getCardErrorMessage(array $payment): string
    {
        $detail = $payment['status_detail'] ?? null;

        $messages = [
            'cc_rejected_bad_filled_card_number'   => 'Número do cartão inválido. Verifique e tente novamente.',
            'cc_rejected_bad_filled_date'          => 'Data de validade do cartão inválida.',
            'cc_rejected_bad_filled_security_code' => 'Código de segurança (CVV) inválido.',
            'cc_rejected_card_number'              => 'Cartão inválido. Verifique o número.',
            'cc_rejected_insufficient_amount'      => 'Saldo insuficiente no cartão.',
            'cc_rejected_other_reason'             => 'Pagamento recusado pela operadora do cartão.',
            'cc_rejected_max_attempts'             => 'Você excedeu o número de tentativas. Tente novamente mais tarde.',
            'cc_rejected_high_risk'                => 'Pagamento recusado por motivo de segurança.',
            'cc_rejected_call_for_authorize'       => 'Entre em contato com o banco emissor para autorizar o pagamento.',
            'cc_rejected_card_disabled'            => 'Cartão desativado. Entre em contato com o banco.',
            'cc_rejected_duplicated_payment'       => 'Pagamento duplicado. Verifique se já foi realizado.',
            'cc_rejected_prepaid_card'             => 'Cartão pré-pago não aceito para esta compra.',
            'cc_rejected_invalid_installments'     => 'Número de parcelas inválido.',
            'cc_rejected_expired_card'             => 'Cartão vencido. Utilize outro cartão.',
        ];

        return $messages[$detail]
            ?? 'Pagamento recusado. Verifique os dados do cartão e tente novamente.';
    }

    protected function formatResponse($response): array
    {
        $json = $response->json();

        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $json,
            ];
        }

        return [
            'success' => false,
            'message' => $this->getErrorMessage($json),
            'data' => $json,
        ];
    }

    // ─────────────────────────────────────────
    // REEMBOLSO
    // ─────────────────────────────────────────
    public function refundPayment(string $paymentId, ?float $amount = null): array
    {
        $payload = [];

        // Se $amount for informado, é reembolso parcial. Sem ele, o MP reembolsa o valor total.
        if ($amount !== null) {
            $payload['amount'] = $amount;
        }

        $response = Http::withToken($this->accessToken)
            ->withHeaders(['X-Idempotency-Key' => (string) Str::uuid()])
            ->post("{$this->baseUrl}/v1/payments/{$paymentId}/refunds", $payload);

        return $this->formatResponse($response);
    }
}