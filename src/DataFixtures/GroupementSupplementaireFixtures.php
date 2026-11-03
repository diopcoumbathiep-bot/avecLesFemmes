<?php

namespace App\DataFixtures;

use App\Entity\Groupement;
use App\Enum\StatutGroupement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Groupements supplementaires pour tester le filtre (telephone, ville) et la pagination.
 */
class GroupementSupplementaireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $villes = ['Dakar', 'Thiès', 'Saint-Louis', 'Kaolack', 'Ziguinchor', 'Touba', 'Mbour', 'Rufisque'];

        for ($i = 0; $i < 10; $i++) {
            $groupement = (new Groupement())
                ->setNomGroupement('Groupement ' . $faker->lastName())
                ->setTel('77' . $faker->numerify('#######'))
                ->setAdresse($faker->streetName() . ', ' . $villes[$i % count($villes)])
                ->setStatut($i % 4 === 3 ? StatutGroupement::INACTIF : StatutGroupement::ACTIF);
            $manager->persist($groupement);
        }

        $manager->flush();
    }
}