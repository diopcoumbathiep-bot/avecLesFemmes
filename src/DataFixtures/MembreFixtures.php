<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Groupement;
use App\Entity\MembreSimple;
use App\Entity\Secretaire;
use App\Entity\Tresoriere;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MembreFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($g = 0; $g < 2; $g++) {
            $groupement = $this->getReference('groupement_' . $g, Groupement::class);

            $membres = [new Admin(), new Secretaire(), new Tresoriere()];
            for ($i = 0; $i < 7; $i++) {
                $membres[] = new MembreSimple();
            }

            foreach ($membres as $i => $membre) {
                $membre->setNomComplet($faker->name('female'));
                $membre->setTelMembre('77' . $faker->numerify('#######'));
                $membre->setAdresseMembre($faker->streetAddress());
                $membre->setLogin($faker->unique()->userName());
                $membre->setPassword(password_hash('motdepasse', PASSWORD_BCRYPT));
                $membre->setGroupement($groupement);
                $manager->persist($membre);

                $this->addReference('membre_' . $g . '_' . $i, $membre);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [GroupementFixtures::class];
    }
}