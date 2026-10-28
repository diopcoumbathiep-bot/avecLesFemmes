<?php

namespace App\Enum;

enum StatutPresence: string
{
    case PRESENT = 'present';
    case ABSENT_REPRESENTE = 'absent_represente';
    case ABSENT = 'absent';

    public function label(): string
    {
        return match ($this) {
            self::PRESENT => 'Présente',
            self::ABSENT_REPRESENTE => 'Absente (représentée)',
            self::ABSENT => 'Absente',
        };
    }
}