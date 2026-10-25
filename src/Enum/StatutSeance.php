<?php

namespace App\Enum;

enum StatutSeance: string
{
    case PLANIFIEE = 'planifiee';
    case TERMINEE = 'terminee';
    case ANNULEE = 'annulee';
}