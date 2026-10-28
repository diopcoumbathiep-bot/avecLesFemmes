<?php

namespace App\DataFixtures;

use App\Entity\Amende;
use App\Entity\Campagne;
use App\Entity\Presence;
use App\Entity\Pret;
use App\Entity\Seance;
use App\Enum\StatutPresence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AmendeFixtures extends Fixture implements DependentFixtureInterface
{
    use MembreReferenceTrait;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // 1. Amendes journalieres : membre absente qui n'a pas cotise.
        //    Montant = nombre de jours de retard x montant de l'amende journaliere.
        for ($n = 0; $n < 4; $n++) {
            $g = intdiv($n, 2);
            $campagne = $this->getReference('campagne_' . $n, Campagne::class);

            for ($k = 0; $k < 3; $k++) {
                $seance = $this->getReference('seance_' . $n . '_' . $k, Seance::class);

                for ($i = 0; $i < 10; $i++) {
                    $presence = $this->getReference('presence_' . $n . '_' . $k . '_' . $i, Presence::class);
                    if ($presence->getStatut() !== StatutPresence::ABSENT) {
                        continue;
                    }

                    $jours = $faker->numberBetween(1, 5);
                    $amende = (new Amende())
                        ->setMotifAmende('Absence sans cotisation')
                        ->setNombreJours($jours)
                        ->setMontantAmende($jours * $campagne->getMontantAmendeJournaliere())
                        ->setDateApplication(
                            \DateTimeImmutable::createFromInterface($seance->getDateSeance())->modify('+' . $jours . ' days')
                        )
                        ->setSeance($seance)
                        ->setMembre($this->membre($g, $i));
                    $manager->persist($amende);
                }
            }
        }

        // 2. Amendes de retard de remboursement de pret
        for ($g = 0; $g < 2; $g++) {
            $pret = $this->getReference('pret_' . $g . '_0', Pret::class);

            $amende = (new Amende())
                ->setMontantAmende(2000)
                ->setMotifAmende('Retard de paiement')
                ->setDateApplication($pret->getDateDemande()->modify('+2 month'))
                ->setPret($pret)
                ->setMembre($pret->getMembre());
            $manager->persist($amende);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [PretFixtures::class, PresenceFixtures::class, SeanceFixtures::class, CampagneFixtures::class];
    }
}