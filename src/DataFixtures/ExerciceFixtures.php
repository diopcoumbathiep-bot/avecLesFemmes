<?php

namespace App\DataFixtures;

use App\Entity\Exercice;
use App\Entity\Groupement;
use App\Enum\StatutExercice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Chaque groupement a un exercice cloture (Tabaski 2025 -> Tabaski 2026)
 * et un exercice en cours (Tabaski 2026 -> deux semaines avant Tabaski 2027).
 */
class ExerciceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $exercices = [
            // [debut, fin, limite des prets, retribution, statut]
            ['2025-06-01', '2026-05-17', '2026-03-31', '2026-05-10', StatutExercice::CLOTURE],
            ['2026-05-24', '2027-05-02', '2027-03-31', '2027-05-09', StatutExercice::EN_COURS],
        ];

        for ($g = 0; $g < 2; $g++) {
            $groupement = $this->getReference('groupement_' . $g, Groupement::class);

            foreach ($exercices as [$debut, $fin, $limite, $retribution, $statut]) {
                $exercice = (new Exercice())
                    ->setGroupement($groupement)
                    ->setDebutAt(new \DateTime($debut))
                    ->setFinAt(new \DateTime($fin))
                    ->setLimitePretsAt(new \DateTime($limite))
                    ->setRetributionAt(new \DateTime($retribution))
                    ->setStatut($statut);
                $manager->persist($exercice);
            }

            // reference vers l'exercice en cours, utilise par les campagnes
            $this->addReference('exercice_' . $g, $exercice);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [GroupementFixtures::class];
    }
}