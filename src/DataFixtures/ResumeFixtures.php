<?php

namespace App\DataFixtures;

use App\Entity\Resume;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ResumeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $resume = new Resume();
        // $manager->persist($resume);

        $manager->flush();
    }
}