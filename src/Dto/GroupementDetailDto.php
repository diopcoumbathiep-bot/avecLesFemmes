<?php

namespace App\Dto;

final readonly class GroupementDetailDto
{
    /**
     * @param CampagneDto[] $campagnes campagnes de l'exercice en cours
     * @param ExerciceDto[] $exercices historique des exercices
     */
    public function __construct(
        public GroupementDto $groupement,
        public array $campagnes,
        public array $exercices,
    ) {
    }
}