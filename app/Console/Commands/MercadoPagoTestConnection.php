<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MercadoPagoTestConnection extends Command
{
    protected $signature = 'mercadopago:test';

    protected $description = 'Testa a conexão com a API do Mercado Pago';

    public function handle()
    {
        $response = Http::withToken(config('services.mercadopago.access_token'))
            ->acceptJson()
            ->withHeaders([
                'X-Idempotency-Key' => (string) Str::uuid(),
            ])
            ->post('https://api.mercadopago.com/v1/payments', [
                'transaction_amount' => 10,
                'description' => 'Teste API',
                'payment_method_id' => 'pix',

                'payer' => [
                    'email' => 'teste@test.com',
                    'first_name' => 'Jose',
                    'last_name' => 'Silva',
                    'identification' => [
                        'type' => 'CPF',
                        'number' => '19119119100',
                    ],
                ],
            ]);

        $this->info('Status: '.$response->status());

        $this->line(json_encode(
            $response->json(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        ));
    }
}