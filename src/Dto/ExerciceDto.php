<?php

namespace App\Dto;

use App\Entity\Exercice;
use App\Enum\StatutExercice;
use App\Util\DateFr;

final readonly class ExerciceDto
{
    public function __construct(
        public int $id,
        public string $debut,
        public string $fin,
        public string $limitePrets,
        public string $retribution,
        public string $statut,
        public bool $enCours,
    ) {
    }

    public static function fromEntity(Exercice $exercice): self
    {
        return new self(
            $exercice->getId(),
            DateFr::longue($exercice->getDebutAt()),
            DateFr::longue($exercice->getFinAt()),
            DateFr::longue($exercice->getLimitePretsAt()),
            DateFr::longue($exercice->getRetributionAt()),
            $exercice->getStatut()->label(),
            $exercice->getStatut() === StatutExercice::EN_COURS,
        );
    }

    public function periode(): string
    {
        return $this->debut . ' → ' . $this->fin;
    }
}