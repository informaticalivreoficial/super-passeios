<?php

namespace App\Enums;

enum TourDateStatusEnum:string
{
    case OPEN = 'OPEN';
    case BLOCKED = 'BLOCKED';
    case FULL = 'FULL';
    case CANCELLED = 'CANCELLED';

    public function label(): string
    {
        return match($this) {
            self::OPEN => 'Disponível',
            self::BLOCKED => 'Bloqueado',
            self::FULL => 'Lotado',
            self::CANCELLED => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::OPEN => 'green',
            self::BLOCKED => 'red',
            self::FULL => 'yellow',
            self::CANCELLED => 'gray',
        };
    }

    public function hex(): string
    {
        return match($this) {
            self::OPEN => '#22c55e',
            self::BLOCKED => '#ef4444',
            self::FULL => '#f59e0b',
            self::CANCELLED => '#64748b',
        };
    }
}