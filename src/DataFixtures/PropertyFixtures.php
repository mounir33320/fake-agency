<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for($i = 0; $i < 100; $i++){
            $property = new Property();
            $property
                ->setTitle($faker->words(3,true))
                ->setDescription($faker->sentence(6,true))
                ->setSurface($faker->numberBetween(20,400))
                ->setPrice($faker->numberBetween(50000,1000000))
                ->setRooms($faker->numberBetween(1,15))
                ->setBedrooms($faker->numberBetween(0,14))
                ->setHeat($faker->numberBetween(0,count(Property::HEAT)-1))
                ->setFloor($faker->numberBetween(0,20))
                ->setAdress($faker->address)
                ->setPostalCode($faker->postcode)
                ->setCity($faker->city)
                ->setSold(false);
            $manager->persist($property);
        }
        $manager->flush();
    }
}
