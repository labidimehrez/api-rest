<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

declare(strict_types=1);
/**
 * @author Mehrez Labidi
 */

namespace App\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

use Doctrine\ORM\EntityRepository;
use App\Entity\{
    Group
};

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function getUsersByGroup($id)
    {
        $group = $id;
        if ($id instanceof Group) {
            $group = $group->getId();
        }
        return $this->getEntityManager()
                        ->createQuery('  SELECT  u  FROM   App\Entity\User u JOIN u.groups g  WHERE g.id =:id ')
                        ->setParameter('id', $group)
                        ->getResult();
    }

    public function loadUserByUsername($usernameOrEmail)
    {
        return $this->createQueryBuilder('u')
                        ->where('u.firstName = :query OR u.lastName = :query')
                        ->setParameter('query', $usernameOrEmail)
                        ->getQuery()
                        ->getOneOrNullResult();
    }
}
