<?php

namespace App\Enum;

enum StatutGroupement: string
{
    case ACTIF = 'actif';
    case INACTIF = 'inactif';

    public function label(): string
    {
        return match ($this) {
            self::ACTIF => 'Actif',
            self::INACTIF => 'Inactif',
        };
    }
}