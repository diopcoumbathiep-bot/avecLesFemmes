<?php

namespace App\Dto;

use App\Entity\Campagne;
use App\Entity\Epargne;
use App\Util\DateFr;

final readonly class CampagneDto
{
    public function __construct(
        public int $id,
        public string $nom,
        public string $type,
        public string $periodicite,
        public string $jourRencontre,
        public int $montant,
        public int $montantCaissePresent,
        public int $montantCaisseAbsent,
        public int $montantAmendeJournaliere,
        public string $debut,
        public string $fin,
        public int $nombreMembres,
        public int $groupementId,
        public string $groupementNom,
    ) {
    }

    public static function fromEntity(Campagne $campagne, int $nombreMembres): self
    {
        $type = $campagne->getTypeCampagne();
        $libelleType = match (true) {
            $type instanceof Epargne && $type->isCalebasse() => 'Épargne calebasse',
            $type instanceof Epargne => 'Épargne',
            default => 'Tontine',
        };
        $groupement = $campagne->getExercice()->getGroupement();

        return new self(
            $campagne->getId(),
            $campagne->getNomCampagne(),
            $libelleType,
            $campagne->getPeriodicite()->label(),
            $campagne->getJourRencontre(),
            $campagne->getMontantCampagne(),
            $campagne->getMontantCaissePresent(),
            $campagne->getMontantCaisseAbsent(),
            $campagne->getMontantAmendeJournaliere(),
            DateFr::longue($campagne->getDateDebutCampagne()),
            DateFr::longue($campagne->getDateFinCampagne()),
            $nombreMembres,
            $groupement->getId(),
            $groupement->getNomGroupement(),
        );
    }
}