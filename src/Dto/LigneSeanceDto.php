<?php

namespace App\Dto;

use App\Entity\Cotisation;
use App\Entity\Presence;
use App\Enum\StatutPresence;

/**
 * Une ligne du detail d'une seance : la presence d'un membre et sa cotisation.
 */
final readonly class LigneSeanceDto
{
    public function __construct(
        public string $nomComplet,
        public string $role,
        public string $presence,
        public string $presenceCode,
        public ?int $montantEpargne,
        public ?int $montantCaisse,
    ) {
    }

    public static function fromEntity(Presence $presence, ?Cotisation $cotisation): self
    {
        $membre = $presence->getMembre();

        return new self(
            $membre->getNomComplet(),
            MembreCampagneDto::role($membre),
            $presence->getStatut()->label(),
            $presence->getStatut()->value,
            $cotisation?->getMontantCotisation(),
            $cotisation?->getMontantCaisse(),
        );
    }

    public function estAbsente(): bool
    {
        return $this->presenceCode === StatutPresence::ABSENT->value;
    }
}