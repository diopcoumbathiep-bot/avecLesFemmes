<?php

namespace App\Enum;

enum StatutPret: string
{
    case EN_ATTENTE = 'en_attente';
    case ACCEPTE = 'accepte';
    case REFUSE = 'refuse';
    case REMBOURSE = 'rembourse';

    public function label(): string
    {
        return match ($this) {
            self::EN_ATTENTE => 'En attente',
            self::ACCEPTE => 'Accepté',
            self::REFUSE => 'Refusé',
            self::REMBOURSE => 'Remboursé',
        };
    }
}