<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{ 

    /**
     * Password encode interface
     * 
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i=1;$i<=50;$i++)
        {
        $user = new User;

        $user->setEmail($faker->email())
            ->setFirstname($faker->firstname())
            ->setLastname($faker->lastname())
            ->setBirthdate($faker->dateTimeBetween())
            ->setNickname($faker->userName());

            $password = $this->encoder->encodePassword($user,'password');
            $user->setPassword($password);

            $manager->persist($user);

            $this->addReference('user_'. $i, $user);
        }
            $manager->flush();
    } 
            
    
    public function getOrders ()
    {
        return 1;
    }

}
