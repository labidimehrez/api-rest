<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DataFixtures\ORM;

/**
 * @author Mehrez Labidi
 */
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\User;
use App\Entity\Group;

class DataExample extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $devGroup = new Group();
        $devGroup->setName("Developpeur");
        $manager->persist($devGroup);

        $moaGroup = new Group();
        $moaGroup->setName("MOA");
        $manager->persist($moaGroup);

        $user = new User();
        $user->setFirstName("mehrez");
        $user->setLastName("labidi");
        $user->addGroup($devGroup);
        $manager->persist($user);

        $user = new User();
        $user->setFirstName("utilisateur");
        $user->setLastName("utilisateur");
        $user->addGroup($moaGroup);
        $manager->persist($user);

        $manager->flush();
    }
}
