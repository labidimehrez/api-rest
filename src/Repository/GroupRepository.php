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

use Doctrine\ORM\EntityRepository;
use App\Entity\{
    User
};

class GroupRepository extends EntityRepository
{
    public function getGroupsByUser($id)
    {
        $user = $id;
        if ($user instanceof User) {
            $user = $user->getId();
        }
        return $this->getEntityManager()
                        ->createQuery('  SELECT  g FROM   App\Entity\Group g JOIN g.users u  WHERE u.id=:id ')
                        ->setParameter('id', $user)
                        ->getResult();
    }
}
