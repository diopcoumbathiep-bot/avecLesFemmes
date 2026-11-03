<?php

namespace App\Repository;

use App\Entity\Groupement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Groupement>
 */
class GroupementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Groupement::class);
    }

    /**
     * Requete unique de la liste : filtre par telephone et/ou par ville, trie par nom,
     * et ne ramene que les lignes de la page demandee.
     * La ville est cherchee dans l'adresse, sans tenir compte des majuscules.
     *
     * @return Paginator<Groupement>
     */
    public function rechercher(?string $telephone, ?string $ville, int $page, int $parPage): Paginator
    {
        $qb = $this->createQueryBuilder('g')
            ->orderBy('g.nomGroupement', 'ASC');

        if ($telephone !== null && $telephone !== '') {
            $qb->andWhere('g.tel LIKE :telephone')
                ->setParameter('telephone', '%' . $telephone . '%');
        }

        if ($ville !== null && $ville !== '') {
            $qb->andWhere('LOWER(g.adresse) LIKE :ville')
                ->setParameter('ville', '%' . mb_strtolower($ville) . '%');
        }

        $qb->setFirstResult(($page - 1) * $parPage)
            ->setMaxResults($parPage);

        return new Paginator($qb, false);
    }

    public function enregistrer(Groupement $groupement): void
    {
        $this->getEntityManager()->persist($groupement);
        $this->getEntityManager()->flush();
    }
}