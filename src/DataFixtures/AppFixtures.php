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

        UserFactory::createMany(5, function () {
            $visited = [];
            $count = rand(1, 10);

            foreach (range(1, $count) as $v) {
                array_push($visited, CountryFactory::random());
            }

            return [
                'countriesVisited' => $visited
            ];
        });
    }
}
