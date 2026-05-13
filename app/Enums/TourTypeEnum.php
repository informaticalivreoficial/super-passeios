<?php

namespace App\Enums;

enum TourTypeEnum: string
{
    case PRIVATE = 'private';
    case SHARED = 'shared';

    public function label(): string
    {
        return match ($this) {
            self::PRIVATE => 'Privativo',
            self::SHARED => 'Compartilhado',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PRIVATE => 'bg-blue-100 text-blue-700',
            self::SHARED => 'bg-green-100 text-green-700',
        };
    }
}