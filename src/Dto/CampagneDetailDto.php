<?php

namespace App\Dto;

final readonly class CampagneDetailDto
{
    /**
     * @param MembreCampagneDto[] $membres
     * @param SeanceDto[]         $seances
     */
    public function __construct(
        public CampagneDto $campagne,
        public array $membres,
        public array $seances,
    ) {
    }

    public function totalEpargne(): int
    {
        return array_sum(array_map(fn (SeanceDto $s) => $s->totalEpargne, $this->seances));
    }

    public function totalCaisseSociale(): int
    {
        return array_sum(array_map(fn (SeanceDto $s) => $s->totalCaisseSociale(), $this->seances));
    }
}