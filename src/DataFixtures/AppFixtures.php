<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures implements FixtureInterface
{
    private $users;
    private $groups;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 3; $i++) {
            $groupName = $faker->city;
            $group = $this->createGroup($groupName);
            $manager->persist($group);

            $this->groups[] = $group;
        }

        for ($i = 0; $i < 5; $i++) {

            $user = $this->createUser(
                $faker->email,
                $faker->lastName,
                $faker->firstName,
                boolval(rand(0,1)),
                $this->getRandomGroup()
            );

            $manager->persist($user);
            $this->users[] = $user;
        }

        $manager->flush();
    }

    private function createGroup($name)
    {
        return new Group($name);
    }

    private function createUser($email, $lastName, $firstName, $active, $group)
    {
        return new User($email, $lastName, $firstName, $active, $group);
    }

    private function getRandomGroup()
    {
        return $this->groups[rand(0, 1)];
    }

}
