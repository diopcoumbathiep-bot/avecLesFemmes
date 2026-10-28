<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\Membre;
use App\Entity\ModeCotisation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ModeCotisationFixtures extends Fixture implements DependentFixtureInterface
{
    use MembreReferenceTrait;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($n = 0; $n < 4; $n++) {
            $g = intdiv($n, 2);
            $campagne = $this->getReference('campagne_' . $n, Campagne::class);

            for ($i = 0; $i < 10; $i++) {
                $mode = new ModeCotisation();
                $mode->setIsLibre($faker->boolean(30));
                $mode->setCampagne($campagne);
                $mode->setMembre($this->membre($g, $i));
                $manager->persist($mode);

                $this->addReference('mode_' . $n . '_' . $i, $mode);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CampagneFixtures::class, MembreFixtures::class];
    }
}