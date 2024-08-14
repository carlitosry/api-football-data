<?php

namespace App\DataFixtures;

use App\Factory\ApiTokenFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Static_;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'userlogged@gmail.com',
            'password' => 'pa$$word',
            'roles' => ['ROLE_USER_READ'],
        ]);

        ApiTokenFactory::createMany(10, static fn () => [
            'ownedBy' => UserFactory::random(),

        ]);

        $manager->flush();
    }
}
