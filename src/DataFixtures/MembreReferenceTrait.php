<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Membre;
use App\Entity\MembreSimple;
use App\Entity\Secretaire;
use App\Entity\Tresoriere;

trait MembreReferenceTrait
{
    private function membre(int $g, int $i): Membre
    {
        $classe = match (true) {
            $i === 0 => Admin::class,
            $i === 1 => Secretaire::class,
            $i === 2 => Tresoriere::class,
            default => MembreSimple::class,
        };

        return $this->getReference('membre_' . $g . '_' . $i, $classe);
    }
}