<?php

namespace App\DataFixtures;

use App\Factory\CountryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CountryFactory::createMany(10,['status' => 'VERIFIED']);
        CountryFactory::createMany(5);
    }
}
