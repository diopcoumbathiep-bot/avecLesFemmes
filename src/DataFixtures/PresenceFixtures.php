<?php

namespace App\DataFixtures;

use App\Entity\Membre;
use App\Entity\Presence;
use App\Entity\Seance;
use App\Enum\StatutPresence;
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
                    // 75 % presentes, 15 % absentes representees, 10 % absentes
                    $tirage = $faker->numberBetween(1, 100);
                    $statut = match (true) {
                        $tirage <= 75 => StatutPresence::PRESENT,
                        $tirage <= 90 => StatutPresence::ABSENT_REPRESENTE,
                        default => StatutPresence::ABSENT,
                    };

                    $presence = (new Presence())
                        ->setStatut($statut)
                        ->setSeance($seance)
                        ->setMembre($this->membre($g, $i));
                    $manager->persist($presence);

                    $this->addReference('presence_' . $n . '_' . $k . '_' . $i, $presence);
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