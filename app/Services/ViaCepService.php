<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ViaCepService
{
    public function find(string $cep): ?array
    {
        $cep = preg_replace('/\D/', '', $cep);

        if (strlen($cep) !== 8) {
            return null;
        }

        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();

        return isset($data['erro']) ? null : $data;
    }
}