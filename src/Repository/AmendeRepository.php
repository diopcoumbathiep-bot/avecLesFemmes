<?php

namespace App\Repository;

use App\Entity\Amende;
use App\Entity\Seance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Amende>
 */
class AmendeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Amende::class);
    }

    /**
     * Total des amendes par seance.
     *
     * @param int[] $seanceIds
     *
     * @return array<int, int>
     */
    public function totauxParSeance(array $seanceIds): array
    {
        if ($seanceIds === []) {
            return [];
        }

        $lignes = $this->createQueryBuilder('a')
            ->select('IDENTITY(a.seance) AS seanceId, SUM(a.montantAmende) AS total')
            ->where('a.seance IN (:ids)')
            ->setParameter('ids', $seanceIds)
            ->groupBy('a.seance')
            ->getQuery()
            ->getArrayResult();

        return array_column(array_map(fn ($l) => [(int) $l['seanceId'], (int) $l['total']], $lignes), 1, 0);
    }

    /**
     * @return Amende[]
     */
    public function findParSeance(Seance $seance): array
    {
        return $this->createQueryBuilder('a')
            ->addSelect('m')
            ->join('a.membre', 'm')
            ->where('a.seance = :seance')
            ->setParameter('seance', $seance)
            ->orderBy('m.nomComplet', 'ASC')
            ->getQuery()
            ->getResult();
    }
}