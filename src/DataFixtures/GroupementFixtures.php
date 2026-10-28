<?php

namespace App\DataFixtures;

use App\Entity\Groupement;
use App\Enum\StatutGroupement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $groupements = [
            ['Groupement Les Solidaires', '771234567', 'Parcelles Assainies, Unité 15, Dakar'],
            ['Groupement Les Batisseuses', '781234567', 'Quartier Escale, Thiès'],
        ];

        foreach ($groupements as $i => [$nom, $tel, $adresse]) {
            $groupement = (new Groupement())
                ->setNomGroupement($nom)
                ->setTel($tel)
                ->setAdresse($adresse)
                ->setStatut(StatutGroupement::ACTIF);
            $manager->persist($groupement);

            $this->addReference('groupement_' . $i, $groupement);
        }

        $manager->flush();
    }
}