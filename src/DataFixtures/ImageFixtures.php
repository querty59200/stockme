<?php

namespace App\DataFixtures;

use App\Controller\LuggageController;
use App\Entity\Image;
use App\Repository\LuggageRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    private $luggageRepository;

    public function __construct(LuggageRepository $luggageRepository)
    {
        $this->luggageRepository = $luggageRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i =0; $i < 200; $i++){
            $image = new Image();
            $image->setName($faker->userName);
            $image->setLink($faker->imageUrl(60, 90, 'cats'));     // 'http://lorempixel.com/800/600/cats/'
            $image->setLuggage($faker->randomElement($this->luggageRepository->findAll()));

            $manager->persist($image);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LuggageFixtures::class,
        );
    }
}
