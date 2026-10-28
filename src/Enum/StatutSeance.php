<?php

namespace App\Enum;

enum StatutSeance: string
{
    case PLANIFIEE = 'planifiee';
    case TERMINEE = 'terminee';
    case ANNULEE = 'annulee';

    public function label(): string
    {
        return match ($this) {
            self::PLANIFIEE => 'Planifiée',
            self::TERMINEE => 'Terminée',
            self::ANNULEE => 'Annulée',
        };
    }
}