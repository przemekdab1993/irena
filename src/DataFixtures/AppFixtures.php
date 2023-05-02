<?php

namespace App\DataFixtures;

use App\Factory\CountryFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CountryFactory::createMany(15,['status' => 'ACTIVE']);
        CountryFactory::createMany(5);

        UserFactory::createMany(5);
    }
}
