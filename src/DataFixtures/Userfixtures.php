<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Userfixtures extends Fixture
{
    private $encoder;
    private $roles;

    public function __construct(UserPasswordEncoderInterface $encoder)
{
    $this->encoder = $encoder;
    $this->roles = array('ROLE_ADMIN','ROLE_USER', 'ROLE_VIEWER');
}

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setEmail('admin@admin.fr');
        $user->setPassword($this->encodePassword($user, 'azerty'));
        $user->setRoles((array)$this->roles[0]);
        $manager->persist($user);
        $manager->flush();


        for($i = 0; $i < 50; $i++){
            $user = new User();
            $user->setEmail($faker->email());
            $user->setPassword($this->encodePassword($user, $faker->password(6, 10)));
            $user->setRoles((array)$this->roles[mt_rand(1, 2)]);
            $manager->persist($user);
        }
        $manager->flush();
    }

    private function encodePassword(User $user, string $plainPassword) : string{
        return  $this->encoder->encodePassword($user, $plainPassword);
    }
}
