<?php

namespace App\DataFixtures;

use App\Factory\CountryFactory;
use App\Factory\LanguageFactory;
use App\Factory\UserAppFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        LanguageFactory::createMany(10);

        CountryFactory::createMany(15, function () {

            return [
                'status' => 'ACTIVE',
                'language' => [LanguageFactory::random()]
            ];
        });

        CountryFactory::createMany(5, function () {
            $lenguages = [];
            $count = rand(1, 2);
            foreach (range(1,$count) as $v) {
                array_push($lenguages, LanguageFactory::random());
            }
            return [
                'language' => $lenguages
            ];
        });

        UserAppFactory::createMany(5, function () {
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
