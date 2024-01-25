<?php

namespace App\DataFixtures;

// use Faker\Factory;
// use Faker\Generator;
use App\Entity\User;
use App\Entity\Alert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    // private Generator $faker;

    // public function __construct()
    // {
    //     $this->faker = Factory::create('fr_FR')
    // }

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setLastname('Mancheron')
        ->setFirstname('Vincent')
        ->setEmail('mancheronv@gmail.com')
        ->setPassword($this->userPasswordHasher->hashPassword($user, "testClimeet"))
        ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);

        $user = new User();
        $user->setLastname('Doe')
        ->setFirstname('John')
        ->setEmail('jdoe@gmail.com')
        ->setPassword($this->userPasswordHasher->hashPassword($user, "testClimeet2"))
        ->setRoles(["ROLE_USER"]);
        $manager->persist($user);

        for ($i = 1; $i <= 10; $i++) {
            $alert = new Alert();
            $alert->setDeviseBase('Bitcoin')
            ->setIdBase('BTC')
            ->setDeviseDiv('Dollars')
            ->setIdDiv('USD')
            ->setMin(20000)
            ->setMax(30000)
            ->setUser($user);
            $manager->persist($alert);
        }
        
        $manager->flush();
    }
}
