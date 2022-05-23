<?php

namespace App\DataFixtures;

use App\Entity\Materiel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create();
        $materiels =  [];

        for($i = 0; $i < 10; $i++)
        {
            $materiel = new Materiel();
            $materiel->setNom($faker->text(30));
            $materiel->setDetail($faker->text(500));
            $materiel->setImage($faker->imageUrl());
            $manager->persist($materiel);
            $materiels[] = $materiel;
        }

        $manager->flush();
    }
}
