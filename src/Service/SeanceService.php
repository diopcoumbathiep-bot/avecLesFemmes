<?php

namespace App\Service;

use App\Dto\AmendeDto;
use App\Dto\CampagneDto;
use App\Dto\LigneSeanceDto;
use App\Dto\SeanceDetailDto;
use App\Dto\SeanceDto;
use App\Enum\StatutPresence;
use App\Repository\AmendeRepository;
use App\Repository\CotisationRepository;
use App\Repository\ModeCotisationRepository;
use App\Repository\PresenceRepository;
use App\Repository\SeanceRepository;

final class SeanceService
{
    public function __construct(
        private readonly SeanceRepository $seanceRepository,
        private readonly PresenceRepository $presenceRepository,
        private readonly CotisationRepository $cotisationRepository,
        private readonly AmendeRepository $amendeRepository,
        private readonly ModeCotisationRepository $modeCotisationRepository,
    ) {
    }

    /**
     * Detail d'une seance : presence et cotisation de chaque membre, amendes et totaux.
     */
    public function detail(int $id): ?SeanceDetailDto
    {
        $seance = $this->seanceRepository->find($id);
        if ($seance === null) {
            return null;
        }

        $campagne = $seance->getCampagne();
        $presences = $this->presenceRepository->findParSeance($seance);
        $cotisations = $this->cotisationRepository->findParSeanceIndexeesParMembre($seance);
        $amendes = $this->amendeRepository->findParSeance($seance);

        $totaux = ['epargne' => 0, 'caisse' => 0];
        foreach ($cotisations as $cotisation) {
            $totaux['epargne'] += $cotisation->getMontantCotisation();
            $totaux['caisse'] += $cotisation->getMontantCaisse();
        }
        $totalAmendes = array_sum(array_map(fn ($a) => $a->getMontantAmende(), $amendes));
        $presents = count(array_filter($presences, fn ($p) => $p->getStatut() === StatutPresence::PRESENT));

        return new SeanceDetailDto(
            SeanceDto::fromEntity($seance, $totaux, $totalAmendes, $presents),
            CampagneDto::fromEntity($campagne, count($this->modeCotisationRepository->findBy(['campagne' => $campagne]))),
            array_map(
                fn ($p) => LigneSeanceDto::fromEntity($p, $cotisations[$p->getMembre()->getId()] ?? null),
                $presences,
            ),
            array_map(fn ($a) => AmendeDto::fromEntity($a), $amendes),
        );
    }
}