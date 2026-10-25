<?php

namespace App\DataFixtures;

use App\Entity\Groupement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $noms = ['Groupement Les Solidaires', 'Groupement Les Batisseuses'];

        foreach ($noms as $i => $nom) {
            $groupement = new Groupement();
            $groupement->setNomGroupement($nom);
            $manager->persist($groupement);

            $this->addReference('groupement_' . $i, $groupement);
        }

        $manager->flush();
    }
}