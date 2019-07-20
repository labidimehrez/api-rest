<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Mehrez Labidi
 */

/**
 * Group
 * @ORM\Table(name="groupes")
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 */
class Group
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=100,unique=true)
     * @Assert\NotBlank(message="name.can.not.be.blank")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_user", type="integer",nullable=true)
     */
    private $nbUser;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
     */
    protected $users;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getNbUser()
    {
        return $this->nbUser;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function incNbUser()
    {
        $this->nbUser = $this->nbUser + 1;
    }

    public function decNbUser()
    {
        $this->nbUser = $this->nbUser - 1;
    }

    public function __construct()
    {
        $this->nbUser = 0;
    }
}
