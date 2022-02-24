<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\User;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AdFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($nbAds=1; $nbAds<=50; $nbAds++)
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

            $ad = new Ad();

            $ad->setOwner($user);
            $ad->setName($faker->realText(25));
            $ad->setDescription($faker->realText(400));
            $ad->setPicture($picture.$faker->numberBetween(1,14));

            // //genere l'upload
            // for($image=1; $image<=2; $image++)
            // {
            //     $img=$faker->image('public/uploads/images/ads');
            //     // $imageAd= new Picture();
            //     $imageAd=setName(str_replace('public/uploads/images/ads', '', $img));

            //     $ad->setPicture($imageAd);
            // }
            $manager->persist($ad);
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