<?php

namespace App\DataFixtures;

// use Faker\Factory;
// use Faker\Generator;
use App\Entity\Alert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    // private Generator $faker;

    // public function __construct()
    // {
    //     $this->faker = Factory::create('fr_FR')
    // }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $alert = new Alert();
            $alert->setDevise('BTC')
            ->setMin(20000)
            ->setMax(30000);
            $manager->persist($alert);
        }
        
        $manager->flush();
    }
}
