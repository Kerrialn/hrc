<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Vacancy;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Validator\Constraints\Date;

class VacancyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 500; $i++) {

            $faker = Factory::create();
            $vacancy = new Vacancy();
            $position = $faker->randomElement(['PHP Developer', 'Accounts manager', 'Pearl Developer', 'React developer', 'Chef', 'Data analyst', 'Java Developer', 'Programmer']);

            $vacancy->setPosition($position);
            $vacancy->setYearsExperience($faker->randomDigit());
            $vacancy->setCategory($this->getReference(CategoryFixtures::CATEGORY_REFERENCE));
            $vacancy->setDescription($faker->paragraph(10));
            $vacancy->setCreatedAt(new DateTime());
            $vacancy->setOwner($this->getReference(UserFixtures::USER_REFERENCE));
            $manager->persist($vacancy);
        }

        $manager->flush();
    }
}
