<?php

namespace App\DataFixtures;
use App\Entity\Album;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i <50 ; $i++) { 
            $album = new Album();
            $album->setNom($this->faker->word())
                ->setAuteur($this->faker->word())
                ->setCommentaire($this->faker->word())
                ->setLieu($this->faker->word());
    
            $manager->persist($album);
        }      

        $manager->flush();
    }
}
