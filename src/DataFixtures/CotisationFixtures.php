<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\Cotisation;
use App\Entity\Membre;
use App\Entity\Seance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CotisationFixtures extends Fixture implements DependentFixtureInterface
{
    use MembreReferenceTrait;
    public function load(ObjectManager $manager): void
    {
        for ($n = 0; $n < 4; $n++) {
            $g = intdiv($n, 2);
            $campagne = $this->getReference('campagne_' . $n, Campagne::class);

            for ($k = 0; $k < 3; $k++) {
                $seance = $this->getReference('seance_' . $n . '_' . $k, Seance::class);

                for ($i = 0; $i < 10; $i++) {
                    $cotisation = new Cotisation();
                    $cotisation->setMontantCotisation($campagne->getMontantCampagne());
                    $cotisation->setDateCotisation(\DateTimeImmutable::createFromInterface($seance->getDateSeance()));
                    $cotisation->setSeance($seance);
                    $cotisation->setMembre($this->membre($g, $i));
                    $manager->persist($cotisation);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [SeanceFixtures::class, MembreFixtures::class, CampagneFixtures::class];
    }
}