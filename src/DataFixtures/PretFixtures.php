<?php

namespace App\DataFixtures;

use App\Entity\ConditionPret;
use App\Entity\Pret;
use App\Enum\StatutPret;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PretFixtures extends Fixture implements DependentFixtureInterface
{
    use MembreReferenceTrait;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $statuts = [StatutPret::ACCEPTE, StatutPret::REMBOURSE, StatutPret::EN_ATTENTE, StatutPret::REFUSE];

        for ($g = 0; $g < 2; $g++) {
            $condition = $this->getReference('condition_pret_' . $g, ConditionPret::class);

            foreach ($statuts as $k => $statut) {
                $pret = new Pret();
                $pret->setMontantPret($faker->numberBetween(20000, 150000));
                $pret->setDateDemande(
                    \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-5 months', '-3 months'))
                );
                $pret->setDuree($faker->randomElement([3, 6, 12]));
                $pret->setTauxInteretPret($condition->getTauxInteret());
                $pret->setStatutPret($statut);
                $pret->setMembre($this->membre($g, $k + 3));
                $pret->setConditionPret($condition);
                $manager->persist($pret);

                $this->addReference('pret_' . $g . '_' . $k, $pret);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ConditionPretFixtures::class, MembreFixtures::class];
    }
}