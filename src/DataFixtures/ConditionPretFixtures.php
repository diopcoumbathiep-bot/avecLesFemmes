<?php

namespace App\DataFixtures;

use App\Entity\ConditionPret;
use App\Entity\Groupement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ConditionPretFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($g = 0; $g < 2; $g++) {
            $condition = new ConditionPret();
            $condition->setTauxInteret(5.0);
            $condition->setDureeMax(12);
            $condition->setMontantMax(200000);
            $condition->setGroupement($this->getReference('groupement_' . $g, Groupement::class));
            $manager->persist($condition);

            $this->addReference('condition_pret_' . $g, $condition);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [GroupementFixtures::class];
    }
}