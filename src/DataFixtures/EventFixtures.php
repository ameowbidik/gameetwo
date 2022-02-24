<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Event;
use App\Entity\Picture;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($nbEvents=1; $nbEvents<=20; $nbEvents++)
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

            $event = new Event();

            $event->setOwner($user);
            $event->setName($faker->realText(25));
            $event->setDescription($faker->realText(400));
            $event->setPicture($picture.$faker->numberBetween(1,14));
            $event->setStartAt($d=$faker->dateTimeBetween('-30 days'));
            $event->setEndAt($d->modify('+2 days'));

            $manager->persist($event);
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