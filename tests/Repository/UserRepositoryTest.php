<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Tests\Repository;

use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of UserRepositoryTest
 *
 * @author mehrez
 */
class UserRepositoryTest extends WebTestCase {

    public function testGetUsersByGroup() {
        
    }

    public function testLoadUserByUsernamep() {
    }

}
