<?php

namespace App\Enum;

enum StatutPret: string
{
    case EN_ATTENTE = 'en_attente';
    case ACCEPTE = 'accepte';
    case REFUSE = 'refuse';
    case REMBOURSE = 'rembourse';
}