<?php

namespace App\Repository;

use App\Entity\ModeCotisation;
use App\Entity\Campagne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ModeCotisation>
 */
class ModeCotisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModeCotisation::class);
    }

    /**
     * @return ModeCotisation[]
     */
    public function findParCampagne(Campagne $campagne): array
    {
        return $this->createQueryBuilder('mc')
            ->addSelect('m')
            ->join('mc.membre', 'm')
            ->where('mc.campagne = :campagne')
            ->setParameter('campagne', $campagne)
            ->orderBy('m.nomComplet', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Nombre de membres inscrits par campagne.
     *
     * @param int[] $campagneIds
     *
     * @return array<int, int>
     */
    public function compterParCampagne(array $campagneIds): array
    {
        if ($campagneIds === []) {
            return [];
        }

        $lignes = $this->createQueryBuilder('mc')
            ->select('IDENTITY(mc.campagne) AS campagneId, COUNT(mc.id) AS total')
            ->where('mc.campagne IN (:ids)')
            ->setParameter('ids', $campagneIds)
            ->groupBy('mc.campagne')
            ->getQuery()
            ->getArrayResult();

        return array_column(array_map(fn ($l) => [(int) $l['campagneId'], (int) $l['total']], $lignes), 1, 0);
    }
}