<?php

namespace App\DataFixtures;

use App\Entity\Option;
use App\Entity\Reaction;
use App\Repository\LuggageRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReactionFixtures extends Fixture implements DependentFixtureInterface {

    private $luggageRepository;
    private $userRepository;

    public function __construct(LuggageRepository $luggageRepository, UserRepository $userRepository)
    {
        $this->luggageRepository = $luggageRepository;
        $this->userRepository= $userRepository;
    }

    public function load(ObjectManager $manager) {

        $faker = Factory::create('fr_Fr');

        for($i = 0; $i < 1000; $i++){
            $reaction = new Reaction();
            $reaction->setLuggage($faker->randomElement($this->luggageRepository->findAll()));
            $reaction->setUser($faker->randomElement($this->userRepository->findAll()));

            $manager->persist($reaction);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(LuggageFixtures::class, Userfixtures::class);
    }
}
