<?php

namespace App\DataFixtures;

use App\Entity\Luggage;
use App\Repository\StorageRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LuggageFixtures extends Fixture implements DependentFixtureInterface
{
    private $storageRepository;

    public function __construct(StorageRepository $storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 50; $i++){
            $luggage = new Luggage();
            $luggage->setName($faker->text(8));
            $luggage->setDescription($faker->text(20));
            $luggage->setAvailable($faker->boolean);
            $luggage->setPrice($faker->randomFloat(2,10,30));
            $luggage->setHeight($faker->randomFloat(2,30,100));
            $luggage->setWidth($faker->randomFloat(2,20,40));
            $luggage->setLength($faker->randomFloat(2,20,60));
            $luggage->setWeight($faker->randomFloat(2,500,5000));
            $luggage->setStorage($faker->randomElement($this->storageRepository->findAll()));

            $manager->persist($luggage);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            StorageFixtures::class,
        );
        }
}
