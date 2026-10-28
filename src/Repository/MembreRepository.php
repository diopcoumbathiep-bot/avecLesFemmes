<?php

namespace App\Repository;

use App\Entity\Membre;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Membre>
 */
class MembreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Membre::class);
    }

    /**
     * Nombre de membres par groupement.
     *
     * @return array<int, int> id du groupement => nombre de membres
     */
    public function compterParGroupement(): array
    {
        $lignes = $this->createQueryBuilder('m')
            ->select('IDENTITY(m.groupement) AS groupementId, COUNT(m.id) AS total')
            ->groupBy('m.groupement')
            ->getQuery()
            ->getArrayResult();

        return array_column(array_map(fn ($l) => [(int) $l['groupementId'], (int) $l['total']], $lignes), 1, 0);
    }
}