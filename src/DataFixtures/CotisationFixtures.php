<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\Cotisation;
use App\Entity\ModeCotisation;
use App\Entity\Presence;
use App\Entity\Seance;
use App\Enum\StatutPresence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Regles de la caisse sociale :
 * - presente : montant d'epargne + montantCaissePresent
 * - absente representee : montant d'epargne + montantCaisseAbsent
 * - absente sans paiement : pas de cotisation (une amende est creee dans AmendeFixtures)
 * Si le mode de cotisation est libre, le montant d'epargne est choisi par le membre.
 */
class CotisationFixtures extends Fixture implements DependentFixtureInterface
{
    use MembreReferenceTrait;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($n = 0; $n < 4; $n++) {
            $g = intdiv($n, 2);
            $campagne = $this->getReference('campagne_' . $n, Campagne::class);

            for ($k = 0; $k < 3; $k++) {
                $seance = $this->getReference('seance_' . $n . '_' . $k, Seance::class);

                for ($i = 0; $i < 10; $i++) {
                    $presence = $this->getReference('presence_' . $n . '_' . $k . '_' . $i, Presence::class);
                    $caisse = match ($presence->getStatut()) {
                        StatutPresence::PRESENT => $campagne->getMontantCaissePresent(),
                        StatutPresence::ABSENT_REPRESENTE => $campagne->getMontantCaisseAbsent(),
                        StatutPresence::ABSENT => null,
                    };
                    if ($caisse === null) {
                        continue;
                    }

                    $mode = $this->getReference('mode_' . $n . '_' . $i, ModeCotisation::class);
                    $montant = $mode->isLibre()
                        ? $faker->randomElement([500, 1000, 1500, 2500, 3000])
                        : $campagne->getMontantCampagne();

                    $cotisation = (new Cotisation())
                        ->setMontantCotisation($montant)
                        ->setMontantCaisse($caisse)
                        ->setDateCotisation(\DateTimeImmutable::createFromInterface($seance->getDateSeance()))
                        ->setSeance($seance)
                        ->setMembre($this->membre($g, $i));
                    $manager->persist($cotisation);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [SeanceFixtures::class, MembreFixtures::class, CampagneFixtures::class, PresenceFixtures::class, ModeCotisationFixtures::class];
    }
}