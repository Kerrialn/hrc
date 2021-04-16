<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user';

    public function __construct(
        private UserPasswordEncoderInterface $encoder
    ) {
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 150; $i++) {
            $faker = Factory::create();
            $user = new User();
            $password = $this->encoder->encodePassword($user, '12345678');
            $user->setName($faker->name());
            $user->setRoles([$faker->randomElement(['ROLE_EMPLOYER', 'ROLE_EMPLOYEE'])]);
            $user->setEmail($faker->email());
            $user->setPassword($password);
            $user->setPhoneNumber($faker->regexify('[0-9]{9}'));
            $manager->persist($user);
        }
        $manager->flush();
        $this->addReference(self::USER_REFERENCE, $user);
    }
}
