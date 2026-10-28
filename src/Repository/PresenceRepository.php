<?php

namespace App\Repository;

use App\Entity\Presence;
use App\Entity\Seance;
use App\Enum\StatutPresence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Presence>
 */
class PresenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Presence::class);
    }

    /**
     * @return Presence[]
     */
    public function findParSeance(Seance $seance): array
    {
        return $this->createQueryBuilder('p')
            ->addSelect('m')
            ->join('p.membre', 'm')
            ->where('p.seance = :seance')
            ->setParameter('seance', $seance)
            ->orderBy('m.nomComplet', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Nombre de membres presentes par seance.
     *
     * @param int[] $seanceIds
     *
     * @return array<int, int>
     */
    public function compterPresentsParSeance(array $seanceIds): array
    {
        if ($seanceIds === []) {
            return [];
        }

        $lignes = $this->createQueryBuilder('p')
            ->select('IDENTITY(p.seance) AS seanceId, COUNT(p.id) AS total')
            ->where('p.seance IN (:ids)')
            ->andWhere('p.statut = :present')
            ->setParameter('ids', $seanceIds)
            ->setParameter('present', StatutPresence::PRESENT)
            ->groupBy('p.seance')
            ->getQuery()
            ->getArrayResult();

        return array_column(array_map(fn ($l) => [(int) $l['seanceId'], (int) $l['total']], $lignes), 1, 0);
    }
}