<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class TimeCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): ?string
    {
        return $value ? substr($value, 0, 5) : null; // retorna HH:MM
    }

    public function set($model, string $key, $value, array $attributes): ?string
    {
        return $value ?: null; // salva como veio
    }
}