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

class GroupManager
{
    private $em;
    private $logger;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function addGroup($request, $translator)
    {
        $group = new Group();
        $name = $request->get('name');
        $result = $this->checkIfExist($name, $translator);
        if ($result["status"] !== true) {
            return $result["message"];
        }
        $group->setName($name);
        $this->em->persist($group);
        $this->em->flush();
        return $result["message"];
    }

    public function editGroup($group, $request, $translator)
    {
        if (!$group instanceof Group) {
            throw new NotFoundEntity();
        }
        $name = $request->get('name');
        $result = $this->checkIfExist($name, $translator);
        if ($result["status"] !== true) {
            return $result["message"];
        }
        $group->setName($name);
        $this->em->persist($group);
        $this->em->flush();
        return $result["message"];
    }

    public function deleteGroup($group)
    {
        if (!$group instanceof Group) {
            throw new NotFoundEntity();
        }
        $this->em->remove($group);
        $this->em->flush();
    }

    public function showGroup($request)
    {
        $array = [
            "name" => ($request->get('name')) ? $request->get('name') : ""
        ];
        return $this->em->getRepository(Group::class)->findBy(
            array_filter($array)
        );
    }

    public function showAllGroups()
    {
        return $this->em->getRepository(Group::class)->findAll();
    }

    public function showUsersGroup($group)
    {
        return $this->em->getRepository(User::class)->getUsersByGroup($group);
    }

    private function checkIfExist($name = null, $translator)
    {
        $criteria = [
            "name" => ($name) ? $name : "",
        ];
        $users = $this->em->getRepository(Group::class)->findBy(array_filter($criteria));
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
