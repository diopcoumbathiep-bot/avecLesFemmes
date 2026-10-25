<?php

namespace App\DataFixtures;

use App\Entity\Amende;
use App\Entity\Pret;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AmendeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($g = 0; $g < 2; $g++) {
            $pret = $this->getReference('pret_' . $g . '_0', Pret::class);

            $amende = new Amende();
            $amende->setMontantAmende(2000);
            $amende->setMotifAmende('Retard de paiement');
            $amende->setDateApplication($pret->getDateDemande()->modify('+2 month'));
            $amende->setPret($pret);
            $manager->persist($amende);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [PretFixtures::class];
    }
}