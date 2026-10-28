<?php

namespace App\Dto;

use App\Entity\Exercice;
use App\Entity\Groupement;
use App\Enum\StatutGroupement;

/**
 * Groupement tel qu'affiche dans les vues : on n'expose que l'exercice en cours,
 * pas la collection complete des exercices.
 */
final readonly class GroupementDto
{
    public function __construct(
        public int $id,
        public string $nom,
        public string $tel,
        public string $adresse,
        public string $statut,
        public bool $actif,
        public int $nombreMembres,
        public ?ExerciceDto $exerciceEnCours,
    ) {
    }

    public static function fromEntity(Groupement $groupement, ?Exercice $exerciceEnCours, int $nombreMembres): self
    {
        return new self(
            $groupement->getId(),
            $groupement->getNomGroupement(),
            $groupement->getTel(),
            $groupement->getAdresse() ?? '—',
            $groupement->getStatut()->label(),
            $groupement->getStatut() === StatutGroupement::ACTIF,
            $nombreMembres,
            $exerciceEnCours !== null ? ExerciceDto::fromEntity($exerciceEnCours) : null,
        );
    }
}