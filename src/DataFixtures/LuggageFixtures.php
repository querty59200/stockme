<?php

namespace App\DataFixtures;

use App\Entity\Luggage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LuggageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 50; $i++){
            $luggage = new Luggage();
            $luggage->setName($faker->text(8));
            $luggage->setDescription($faker->text(20));
            $luggage->setAvailable($faker->boolean);
            $luggage->setPrice($faker->randomFloat(2,10,30));
            $luggage->setHeight($faker->randomFloat(2,100,200));
            $luggage->setWidth($faker->randomFloat(2,100,200));
            $luggage->setLength($faker->randomFloat(2,100,200));
            $luggage->setWeight($faker->randomFloat(2,500,5000));

            $manager->persist($luggage);
        }
        $manager->flush();
    }
}
