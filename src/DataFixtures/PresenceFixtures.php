<?php

namespace App\DataFixtures;

use App\Entity\Membre;
use App\Entity\Presence;
use App\Entity\Seance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PresenceFixtures extends Fixture implements DependentFixtureInterface
{
    use MembreReferenceTrait;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($n = 0; $n < 4; $n++) {
            $g = intdiv($n, 2);

            for ($k = 0; $k < 3; $k++) {
                $seance = $this->getReference('seance_' . $n . '_' . $k, Seance::class);

                for ($i = 0; $i < 10; $i++) {
                    $presence = new Presence();
                    $presence->setEstPresent($faker->boolean(85));
                    $presence->setSeance($seance);
                    $presence->setMembre($this->membre($g, $i));
                    $manager->persist($presence);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [SeanceFixtures::class, MembreFixtures::class];
    }
}