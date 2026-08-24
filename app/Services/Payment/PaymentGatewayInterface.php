<?php

namespace App\Services\Payment;

interface PaymentGatewayInterface
{
    public function getName(): string;

    public function createPixPayment(array $data): array;

    public function createCardPayment(array $data): array;

    public function getPayment(string $paymentId): array;

    public function getCardErrorMessage(array $payment): string;

    public function refundPayment(string $paymentId, ?float $amount = null): array;
}
