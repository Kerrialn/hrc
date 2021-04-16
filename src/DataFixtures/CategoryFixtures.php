<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORY_REFERENCE = 'category';

    public function load(ObjectManager $manager)
    {

        $industries = ["Accounting", "Administration & Office Support", "Advertising, Arts & Media", "Banking & Financial Services", "Call Centre & Customer Service", "Community Services & Development", "Construction", "Consulting & Strategy", "Design & Architechture", "Education & Training", "Engineering", "Farming, Animals & Conservation", "Government & Defence", "Healthcare & Medical", "Hospitality & Tourism", "Human Resources & Recruitment", "Information & Communication Technology", "Insurance & Superannuation", "Legal", "Manufacturing, Transport & Logistics", "Marketing & Communications", "Mining, Resources & Energy", "Real Estate & Property", "Retail & Consumer Products", "Sales", "Science & Technology", "Sport & Recreation", "Trades & Services"];
        foreach ($industries as $industry) {
            $category = new Category();
            $category->setTitle($industry);
            $manager->persist($category);
        }
        $manager->flush();
        $this->addReference(self::CATEGORY_REFERENCE, $category);
    }
}
