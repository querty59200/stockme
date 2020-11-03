<?php

namespace App\DataFixtures;

use App\Entity\Option;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OptionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_Fr');

        for($i = 0; $i < 10; $i++){
            $option = new Option();
            $option->setName($faker->text(20));
            $manager->persist($option);
        }

        $manager->flush();
    }
}
