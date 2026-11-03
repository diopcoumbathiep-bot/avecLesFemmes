<?php

namespace App\Service;

use App\Dto\CampagneDto;
use App\Dto\ExerciceDto;
use App\Dto\GroupementDetailDto;
use App\Dto\GroupementDto;
use App\Dto\GroupementFiltreDto;
use App\Dto\GroupementFormDto;
use App\Dto\GroupementPageDto;
use App\Entity\Groupement;
use App\Repository\CampagneRepository;
use App\Repository\ExerciceRepository;
use App\Repository\GroupementRepository;
use App\Repository\MembreRepository;
use App\Repository\ModeCotisationRepository;

final class GroupementService
{
    private const PAR_PAGE = 5;

    public function __construct(
        private readonly GroupementRepository $groupementRepository,
        private readonly ExerciceRepository $exerciceRepository,
        private readonly MembreRepository $membreRepository,
        private readonly CampagneRepository $campagneRepository,
        private readonly ModeCotisationRepository $modeCotisationRepository,
    ) {
    }

    /**
     * Liste des groupements : c'est cette methode qui filtre, pagine et prepare l'affichage.
     */
    public function lister(GroupementFiltreDto $filtre): GroupementPageDto
    {
        $page = max(1, $filtre->page);

        $resultat = $this->groupementRepository->rechercher($filtre->telephone, $filtre->ville, $page, self::PAR_PAGE);
        $total = count($resultat);
        $totalPages = max(1, (int) ceil($total / self::PAR_PAGE));

        // page demandee trop grande (ex. apres un filtre) : on revient a la derniere page
        if ($page > $totalPages) {
            $page = $totalPages;
            $resultat = $this->groupementRepository->rechercher($filtre->telephone, $filtre->ville, $page, self::PAR_PAGE);
        }

        $exercicesEnCours = $this->exerciceRepository->findEnCoursIndexesParGroupement();
        $nombreMembres = $this->membreRepository->compterParGroupement();

        $groupements = [];
        foreach ($resultat as $groupement) {
            $groupements[] = GroupementDto::fromEntity(
                $groupement,
                $exercicesEnCours[$groupement->getId()] ?? null,
                $nombreMembres[$groupement->getId()] ?? 0,
            );
        }

        return new GroupementPageDto(
            $groupements,
            $page,
            $totalPages,
            $total,
            $filtre->telephone ?? '',
            $filtre->ville ?? '',
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

    /**
     * DTO pre-rempli pour le formulaire de modification.
     */
    public function formulaire(int $id): ?GroupementFormDto
    {
        $groupement = $this->groupementRepository->find($id);

        return $groupement !== null ? GroupementFormDto::fromEntity($groupement) : null;
    }

    /**
     * Cree un groupement a partir du DTO du formulaire et renvoie son id.
     */
    public function creer(GroupementFormDto $dto): int
    {
        $groupement = new Groupement();
        $this->appliquer($groupement, $dto);
        $this->groupementRepository->enregistrer($groupement);

        return $groupement->getId();
    }

    /**
     * Modifie un groupement a partir du DTO du formulaire. Renvoie false s'il n'existe pas.
     */
    public function modifier(int $id, GroupementFormDto $dto): bool
    {
        $groupement = $this->groupementRepository->find($id);
        if ($groupement === null) {
            return false;
        }

        $this->appliquer($groupement, $dto);
        $this->groupementRepository->enregistrer($groupement);

        return true;
    }

    private function appliquer(Groupement $groupement, GroupementFormDto $dto): void
    {
        $groupement
            ->setNomGroupement((string) $dto->nom)
            ->setTel((string) $dto->tel)
            ->setAdresse($dto->adresse)
            ->setStatut($dto->statut);
    }
}