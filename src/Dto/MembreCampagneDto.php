<?php

namespace App\Dto;

use App\Entity\Admin;
use App\Entity\Membre;
use App\Entity\ModeCotisation;
use App\Entity\Secretaire;
use App\Entity\Tresoriere;

/**
 * Un membre inscrit a une campagne, avec son mode de cotisation.
 */
final readonly class MembreCampagneDto
{
    public function __construct(
        public int $id,
        public string $nomComplet,
        public string $tel,
        public string $role,
        public bool $libre,
        public ?int $montantAttendu,
    ) {
    }

    public static function fromEntity(ModeCotisation $mode): self
    {
        $membre = $mode->getMembre();

        return new self(
            $membre->getId(),
            $membre->getNomComplet(),
            $membre->getTelMembre(),
            self::role($membre),
            (bool) $mode->isLibre(),
            // montant libre : saisi a chaque seance, donc pas de montant attendu
            $mode->isLibre() ? null : $mode->getCampagne()->getMontantCampagne(),
        );
    }

    public static function role(Membre $membre): string
    {
        return match (true) {
            $membre instanceof Admin => 'Admin',
            $membre instanceof Secretaire => 'Secrétaire',
            $membre instanceof Tresoriere => 'Trésorière',
            default => 'Membre',
        };
    }
}