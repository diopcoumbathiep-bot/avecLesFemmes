<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\Membre;
use App\Entity\Seance;
use App\Enum\StatutSeance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeanceFixtures extends Fixture implements DependentFixtureInterface
{
    use MembreReferenceTrait;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($n = 0; $n < 4; $n++) {
            $g = intdiv($n, 2);
            $estTontine = $n % 2 === 1;
            $campagne = $this->getReference('campagne_' . $n, Campagne::class);

            for ($k = 0; $k < 4; $k++) {
                $date = \DateTime::createFromInterface($campagne->getDateDebutCampagne());

                $seance = new Seance();
                $seance->setDateSeance($date->modify('+' . ($k * 2) . ' weeks'));
                $seance->setStatutSeance($k < 3 ? StatutSeance::TERMINEE : StatutSeance::PLANIFIEE);
                $seance->setCompteRendu($k < 3 ? $faker->paragraph() : null);
                $seance->setCampagne($campagne);

                if ($estTontine) {
                    $seance->setBeneficiaire(
                        $this->membre($g, 3 + $k)
                    );
                }

                $manager->persist($seance);
                $this->addReference('seance_' . $n . '_' . $k, $seance);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CampagneFixtures::class, MembreFixtures::class];
    }
}