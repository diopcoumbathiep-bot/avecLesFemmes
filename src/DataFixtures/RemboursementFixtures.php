<?php

namespace App\DataFixtures;

use App\Entity\Pret;
use App\Entity\Remboursement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RemboursementFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($g = 0; $g < 2; $g++) {
            foreach ([0 => 1, 1 => 3] as $k => $nombre) {
                $pret = $this->getReference('pret_' . $g . '_' . $k, Pret::class);

                for ($r = 1; $r <= $nombre; $r++) {
                    $remboursement = new Remboursement();
                    $remboursement->setMontantRemboursement(intdiv($pret->getMontantPret(), 3));
                    $remboursement->setDateRemboursement($pret->getDateDemande()->modify('+' . $r . ' month'));
                    $remboursement->setPret($pret);
                    $manager->persist($remboursement);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [PretFixtures::class];
    }
}