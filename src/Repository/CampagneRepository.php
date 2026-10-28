<?php

namespace App\Repository;

use App\Entity\Campagne;
use App\Entity\Exercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Campagne>
 */
class CampagneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campagne::class);
    }

    /**
     * @return Campagne[]
     */
    public function findParExercice(Exercice $exercice): array
    {
        return $this->createQueryBuilder('c')
            ->addSelect('t')
            ->join('c.typeCampagne', 't')
            ->where('c.exercice = :exercice')
            ->setParameter('exercice', $exercice)
            ->orderBy('c.dateDebutCampagne', 'ASC')
            ->addOrderBy('c.nomCampagne', 'ASC')
            ->getQuery()
            ->getResult();
    }
}