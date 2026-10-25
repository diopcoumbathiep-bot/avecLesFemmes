<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\Epargne;
use App\Entity\Groupement;
use App\Entity\Tontine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CampagneFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $numero = 0;

        for ($g = 0; $g < 2; $g++) {
            $groupement = $this->getReference('groupement_' . $g, Groupement::class);

            foreach (['Epargne', 'Tontine'] as $genre) {
                if ($genre === 'Epargne') {
                    $type = new Epargne();
                    $type->setObjectif($faker->numberBetween(500000, 2000000));
                } else {
                    $type = new Tontine();
                }
                $type->setNomType($genre);
                $manager->persist($type);

                $debut = $faker->dateTimeBetween('-6 months', '-2 months');

                $campagne = new Campagne();
                $campagne->setNomCampagne('Campagne ' . $genre . ' ' . ($g + 1));
                $campagne->setDateDebutCampagne($debut);
                $campagne->setDateFinCampagne((clone $debut)->modify('+8 months'));
                $campagne->setMontantCampagne($faker->randomElement([5000, 10000, 20000]));
                $campagne->setFrequence($faker->randomElement(['hebdomadaire', 'mensuelle']));
                $campagne->setCreateAt(new \DateTimeImmutable());
                $campagne->setTypeCampagne($type);
                $campagne->setGroupement($groupement);
                $manager->persist($campagne);

                $this->addReference('campagne_' . $numero, $campagne);
                $numero++;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [GroupementFixtures::class];
    }
}