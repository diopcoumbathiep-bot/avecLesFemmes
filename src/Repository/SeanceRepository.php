<?php

namespace App\Repository;

use App\Entity\Seance;
use App\Entity\Campagne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Seance>
 */
class SeanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seance::class);
    }

    /**
     * @return Seance[]
     */
    public function findParCampagne(Campagne $campagne): array
    {
        return $this->createQueryBuilder('s')
            ->addSelect('b')
            ->leftJoin('s.beneficiaire', 'b')
            ->where('s.campagne = :campagne')
            ->setParameter('campagne', $campagne)
            ->orderBy('s.dateSeance', 'ASC')
            ->getQuery()
            ->getResult();
    }
}