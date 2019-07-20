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

namespace App\EntityManagers;

use App\Exception\NotFoundEntity;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Group;

class UserManager
{
    private $em;
    private $logger;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function addUser($request, $translator)
    {
        $user = new User();
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');
        $result = $this->checkIfExist($firstName, $lastName, $translator);
        if ($result["status"] !== true) {
            return $result["message"];
        }
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $this->em->persist($user);
        $this->em->flush();
        return $result["message"];
    }

    public function addUserToGroup($user, $group)
    {
        if (!$user instanceof User || !$group instanceof Group) {
            throw new NotFoundEntity();
        }
        $user->addGroup($group);
        $this->em->persist($user);
        $group->incNbUser();
        $this->em->persist($group);
        $this->em->flush();
    }

    public function deleteUserFromGroup($user, $group)
    {
        if (!$user instanceof User || !$group instanceof Group) {
            throw new NotFoundEntity();
        }
        $user->removeGroup($group);
        $this->em->persist($user);
        $group->decNbUser();
        $this->em->persist($group);
        $this->em->flush();
    }

    public function editUser($user, $request, $translator)
    {
        if (!$user instanceof User) {
            throw new NotFoundEntity();
        }
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');

        $result = $this->checkIfExist($firstName, $lastName, $translator);
        if ($result["status"] !== true) {
            return $result["message"];
        }
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        
        $this->em->persist($user);
        $this->em->flush();
        return $result["message"];
    }

    public function deleteUser($user)
    {
        if (!$user instanceof User) {
            throw new NotFoundEntity();
        }
        $this->em->remove($user);
        $this->em->flush();
    }

    public function showUser($request)
    {
        $array = [
            "lastName" => ($request->get('last_name')) ? $request->get('last_name') : "",
            "firstName" => ($request->get('first_name')) ? $request->get('first_name') : ""
        ];
        return $this->em->getRepository(User::class)->findBy(
            array_filter($array)
        );
    }

    public function showAllUsers()
    {
        return $this->em->getRepository(User::class)->findAll();
    }

    public function showGroupsUser($idUser)
    {
        return $this->em->getRepository(Group::class)->getGroupsByUser($idUser);
    }

    private function checkIfExist($firstName = null, $lastName = null, $translator)
    {
        $criteria = [
            "firstName" => ($firstName) ? $firstName : "",
            "lastName" => ($lastName) ? $lastName : ""
        ];
        $users = $this->em->getRepository(User::class)->findBy(array_filter($criteria));
        if (count($users) > 0) {
            $result = [
                "status" => false, "message" => $translator->trans('error', array(), 'message')
            ];
        } else {
            $result = [
                "status" => true,
                "message" => $translator->trans('success', array(), 'message')
            ];
        }
        return $result;
    }
}
