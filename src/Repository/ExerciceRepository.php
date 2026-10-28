<?php

namespace App\Repository;

use App\Entity\Exercice;
use App\Entity\Groupement;
use App\Enum\StatutExercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exercice>
 */
class ExerciceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercice::class);
    }

    /**
     * Exercices en cours de tous les groupements, indexes par id de groupement.
     *
     * @return array<int, Exercice>
     */
    public function findEnCoursIndexesParGroupement(): array
    {
        $exercices = $this->createQueryBuilder('e')
            ->addSelect('g')
            ->join('e.groupement', 'g')
            ->where('e.statut = :statut')
            ->setParameter('statut', StatutExercice::EN_COURS)
            ->getQuery()
            ->getResult();

        $resultat = [];
        foreach ($exercices as $exercice) {
            $resultat[$exercice->getGroupement()->getId()] = $exercice;
        }

        return $resultat;
    }

    public function findEnCoursPourGroupement(Groupement $groupement): ?Exercice
    {
        return $this->findOneBy(['groupement' => $groupement, 'statut' => StatutExercice::EN_COURS]);
    }

    /**
     * @return Exercice[]
     */
    public function findParGroupement(Groupement $groupement): array
    {
        return $this->findBy(['groupement' => $groupement], ['debutAt' => 'DESC']);
    }
}