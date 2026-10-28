<?php

namespace App\Dto;

use App\Entity\Seance;
use App\Enum\StatutSeance;
use App\Util\DateFr;

/**
 * Une seance avec ses totaux : epargne collectee, caisse sociale et amendes.
 */
final readonly class SeanceDto
{
    public function __construct(
        public int $id,
        public string $date,
        public string $statut,
        public bool $terminee,
        public ?string $beneficiaire,
        public int $nombrePresents,
        public int $totalEpargne,
        public int $totalCaisse,
        public int $totalAmendes,
    ) {
    }

    /**
     * @param array{epargne: int, caisse: int} $totauxCotisations
     */
    public static function fromEntity(Seance $seance, array $totauxCotisations, int $totalAmendes, int $nombrePresents): self
    {
        return new self(
            $seance->getId(),
            DateFr::avecJour($seance->getDateSeance()),
            $seance->getStatutSeance()->label(),
            $seance->getStatutSeance() === StatutSeance::TERMINEE,
            $seance->getBeneficiaire()?->getNomComplet(),
            $nombrePresents,
            $totauxCotisations['epargne'],
            $totauxCotisations['caisse'],
            $totalAmendes,
        );
    }

    /** Caisse sociale de la seance = cotisations de caisse + amendes */
    public function totalCaisseSociale(): int
    {
        return $this->totalCaisse + $this->totalAmendes;
    }

    public function totalEncaisse(): int
    {
        return $this->totalEpargne + $this->totalCaisseSociale();
    }
}