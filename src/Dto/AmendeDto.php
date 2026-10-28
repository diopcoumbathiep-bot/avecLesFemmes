<?php

namespace App\Dto;

use App\Entity\Amende;
use App\Util\DateFr;

final readonly class AmendeDto
{
    public function __construct(
        public string $membre,
        public string $motif,
        public ?int $nombreJours,
        public int $montant,
        public string $dateApplication,
    ) {
    }

    public static function fromEntity(Amende $amende): self
    {
        return new self(
            $amende->getMembre()->getNomComplet(),
            $amende->getMotifAmende(),
            $amende->getNombreJours(),
            $amende->getMontantAmende(),
            DateFr::longue($amende->getDateApplication()),
        );
    }
}