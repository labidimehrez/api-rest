<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Group;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Mehrez Labidi
 */

/**
 * User
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=100)
     * @Assert\NotBlank(message="firstname.can.not.be.blank")
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=100)
     * @Assert\NotBlank(message="lastname.can.not.be.blank")
     */
    private $lastName;

    /**
     * @Assert\NotBlank(message="group.can.not.be.blank")
     * @ORM\ManyToMany(targetEntity="Group")
     * @ORM\JoinTable(name="user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @ORM\Column(type="string", unique=true,  nullable=true)
     */
    private $apiToken;

    public function getApiToken()
    {
        return $this->apiToken;
    }

    public function setApiToken($apiToken)
    {
        $this->apiToken = $apiToken;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getGroups()
    {
        return $this->groups;
    }

    public function setGroups($groups)
    {
        $this->groups = new ArrayCollection();
        $this->groups[] = $groups;

        return $this;
    }

    public function addGroup($groups)
    {
        $this->groups[] = $groups;
        return $this;
    }

    public function removeGroup($groups)
    {
        $this->groups->removeElement($groups);
    }

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    public function getRoles()
    {
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }
}
