<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\Epargne;
use App\Entity\Exercice;
use App\Entity\Tontine;
use App\Enum\Periodicite;
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
            $exercice = $this->getReference('exercice_' . $g, Exercice::class);

            foreach (['Epargne', 'Tontine'] as $genre) {
                if ($genre === 'Epargne') {
                    // l'epargne calebasse dure tout l'exercice
                    $type = (new Epargne())
                        ->setObjectif($faker->numberBetween(500000, 2000000))
                        ->setIsCalebasse(true);
                    $nom = 'Épargne calebasse';
                    $fin = clone $exercice->getFinAt();
                } else {
                    $type = new Tontine();
                    $nom = 'Tontine';
                    $fin = new \DateTime('2027-01-31');
                }
                $type->setNomType($genre);
                $manager->persist($type);

                $campagne = (new Campagne())
                    ->setNomCampagne($nom . ' ' . ($g + 1))
                    ->setDateDebutCampagne(new \DateTime('2026-09-27'))
                    ->setDateFinCampagne($fin)
                    ->setMontantCampagne($faker->randomElement([1000, 2000, 5000]))
                    ->setPeriodicite(Periodicite::PAR_QUINZAINE)
                    ->setJourRencontre('Dimanche')
                    ->setMontantCaissePresent(100)
                    ->setMontantCaisseAbsent(300)
                    ->setMontantAmendeJournaliere(350)
                    ->setTypeCampagne($type)
                    ->setExercice($exercice);
                $manager->persist($campagne);

                $this->addReference('campagne_' . $numero, $campagne);
                $numero++;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ExerciceFixtures::class];
    }
}