<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Hotnew;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class HotnewFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($nbHotnews=1; $nbHotnews<=10; $nbHotnews++)
        {
            $picture = $faker->randomElement(['http://picsum.photos/450/250?random=1',
            'http://picsum.photos/450/250?random=2',
            'http://picsum.photos/450/250?random=3',
            'http://picsum.photos/450/250?random=4',
            'http://picsum.photos/450/250?random=5',
            'http://picsum.photos/450/250?random=6',
            'http://picsum.photos/450/250?random=7',
            'http://picsum.photos/450/250?random=8',
            'http://picsum.photos/450/250?random=9',
            'http://picsum.photos/450/250?random=10',
            'http://picsum.photos/450/250?random=11',
            'http://picsum.photos/450/250?random=12',
            'http://picsum.photos/450/250?random=13',
            'http://picsum.photos/450/250?random=14',
        ]);

        $user =$this->getReference('user_'.$faker->numberBetween(1,50));
        
        $hotnew = new Hotnew();

        $hotnew->setTitle($faker->title());
        $hotnew->setUser($user);
        $hotnew->setContent($faker->text());
        $hotnew->setCreateAt($faker->dateTime());
        $hotnew->setPublishAt($faker->dateTime());
        $hotnew->setPicture($picture.$faker->numberBetween(1,14));

        $manager->persist($hotnew);

        
        }
        $manager->flush();
        
    }
    public function getDependencies()
    {
        return[
            UserFixtures::class
        ];
    }    
} 