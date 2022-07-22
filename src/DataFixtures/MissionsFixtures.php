<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Missions;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MissionsFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i = 0; $i < 20; $i++)
        {
           $mission = new Missions();
           $mission
           ->setTitle($faker->words(3, true))
           ->setDescription($faker->sentence(4))
           ->setCountry($faker->countryCode())
           ->setType(Missions::TYPE[$faker->numberBetween(0, 2)])
           ->setCodeName($faker->word())
           ->setStartDate(new \DateTime('now'))
           ->setEndDate(new \DateTime('now'))
           ->setSpeciality(Missions::SPEC[$faker->numberBetween(0, 2)])
           ;

           $manager->persist($mission);
        }

        $manager->flush();
    }
}
