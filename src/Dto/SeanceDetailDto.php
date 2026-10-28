<?php

namespace App\Dto;

final readonly class SeanceDetailDto
{
    /**
     * @param LigneSeanceDto[] $lignes
     * @param AmendeDto[]      $amendes
     */
    public function __construct(
        public SeanceDto $seance,
        public CampagneDto $campagne,
        public array $lignes,
        public array $amendes,
    ) {
    }
}