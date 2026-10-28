<?php

namespace App\Service;

use App\Dto\CampagneDto;
use App\Dto\ExerciceDto;
use App\Dto\GroupementDetailDto;
use App\Dto\GroupementDto;
use App\Repository\CampagneRepository;
use App\Repository\ExerciceRepository;
use App\Repository\GroupementRepository;
use App\Repository\MembreRepository;
use App\Repository\ModeCotisationRepository;

final class GroupementService
{
    public function __construct(
        private readonly GroupementRepository $groupementRepository,
        private readonly ExerciceRepository $exerciceRepository,
        private readonly MembreRepository $membreRepository,
        private readonly CampagneRepository $campagneRepository,
        private readonly ModeCotisationRepository $modeCotisationRepository,
    ) {
    }

    /**
     * Liste des groupements avec leur exercice en cours.
     *
     * @return GroupementDto[]
     */
    public function lister(): array
    {
        $exercicesEnCours = $this->exerciceRepository->findEnCoursIndexesParGroupement();
        $nombreMembres = $this->membreRepository->compterParGroupement();

        return array_map(
            fn ($groupement) => GroupementDto::fromEntity(
                $groupement,
                $exercicesEnCours[$groupement->getId()] ?? null,
                $nombreMembres[$groupement->getId()] ?? 0,
            ),
            $this->groupementRepository->findTousParNom(),
        );
    }

    /**
     * Detail d'un groupement : campagnes de l'exercice en cours et historique des exercices.
     */
    public function detail(int $id): ?GroupementDetailDto
    {
        $groupement = $this->groupementRepository->find($id);
        if ($groupement === null) {
            return null;
        }

        $exerciceEnCours = $this->exerciceRepository->findEnCoursPourGroupement($groupement);
        $campagnes = $exerciceEnCours !== null ? $this->campagneRepository->findParExercice($exerciceEnCours) : [];
        $membresParCampagne = $this->modeCotisationRepository->compterParCampagne(
            array_map(fn ($c) => $c->getId(), $campagnes)
        );

        return new GroupementDetailDto(
            GroupementDto::fromEntity($groupement, $exerciceEnCours, $groupement->getMembres()->count()),
            array_map(fn ($c) => CampagneDto::fromEntity($c, $membresParCampagne[$c->getId()] ?? 0), $campagnes),
            array_map(fn ($e) => ExerciceDto::fromEntity($e), $this->exerciceRepository->findParGroupement($groupement)),
        );
    }
}