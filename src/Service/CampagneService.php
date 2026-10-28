<?php

namespace App\Service;

use App\Dto\CampagneDetailDto;
use App\Dto\CampagneDto;
use App\Dto\MembreCampagneDto;
use App\Dto\SeanceDto;
use App\Repository\AmendeRepository;
use App\Repository\CampagneRepository;
use App\Repository\CotisationRepository;
use App\Repository\ModeCotisationRepository;
use App\Repository\PresenceRepository;
use App\Repository\SeanceRepository;

final class CampagneService
{
    public function __construct(
        private readonly CampagneRepository $campagneRepository,
        private readonly ModeCotisationRepository $modeCotisationRepository,
        private readonly SeanceRepository $seanceRepository,
        private readonly CotisationRepository $cotisationRepository,
        private readonly AmendeRepository $amendeRepository,
        private readonly PresenceRepository $presenceRepository,
    ) {
    }

    /**
     * Detail d'une campagne : ses membres et ses seances avec les totaux.
     */
    public function detail(int $id): ?CampagneDetailDto
    {
        $campagne = $this->campagneRepository->find($id);
        if ($campagne === null) {
            return null;
        }

        $modes = $this->modeCotisationRepository->findParCampagne($campagne);
        $seances = $this->seanceRepository->findParCampagne($campagne);

        $ids = array_map(fn ($s) => $s->getId(), $seances);
        $totauxCotisations = $this->cotisationRepository->totauxParSeance($ids);
        $totauxAmendes = $this->amendeRepository->totauxParSeance($ids);
        $presents = $this->presenceRepository->compterPresentsParSeance($ids);

        return new CampagneDetailDto(
            CampagneDto::fromEntity($campagne, count($modes)),
            array_map(fn ($mode) => MembreCampagneDto::fromEntity($mode), $modes),
            array_map(fn ($s) => SeanceDto::fromEntity(
                $s,
                $totauxCotisations[$s->getId()] ?? ['epargne' => 0, 'caisse' => 0],
                $totauxAmendes[$s->getId()] ?? 0,
                $presents[$s->getId()] ?? 0,
            ), $seances),
        );
    }
}