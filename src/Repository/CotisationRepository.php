<?php

namespace App\Repository;

use App\Entity\Cotisation;
use App\Entity\Seance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cotisation>
 */
class CotisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cotisation::class);
    }

    /**
     * Total de l'epargne et de la caisse collectees par seance.
     *
     * @param int[] $seanceIds
     *
     * @return array<int, array{epargne: int, caisse: int}>
     */
    public function totauxParSeance(array $seanceIds): array
    {
        if ($seanceIds === []) {
            return [];
        }

        $lignes = $this->createQueryBuilder('c')
            ->select('IDENTITY(c.seance) AS seanceId, SUM(c.montantCotisation) AS epargne, SUM(c.montantCaisse) AS caisse')
            ->where('c.seance IN (:ids)')
            ->setParameter('ids', $seanceIds)
            ->groupBy('c.seance')
            ->getQuery()
            ->getArrayResult();

        $totaux = [];
        foreach ($lignes as $ligne) {
            $totaux[(int) $ligne['seanceId']] = ['epargne' => (int) $ligne['epargne'], 'caisse' => (int) $ligne['caisse']];
        }

        return $totaux;
    }

    /**
     * Cotisations d'une seance, indexees par id de membre.
     *
     * @return array<int, Cotisation>
     */
    public function findParSeanceIndexeesParMembre(Seance $seance): array
    {
        $resultat = [];
        foreach ($this->findBy(['seance' => $seance]) as $cotisation) {
            $resultat[$cotisation->getMembre()->getId()] = $cotisation;
        }

        return $resultat;
    }
}