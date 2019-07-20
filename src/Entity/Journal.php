<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Mehrez Labidi
 */

/**
 * Journal
 * @ORM\Table(name="journal")
 * @ORM\Entity(repositoryClass="App\Repository\JournalRepository")
 */
class Journal
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
     * @var string|null
     *
     * @ORM\Column(name="url", type="text",  nullable=true)
     */
    private $url;

    /**
     * @var string
     * @ORM\Column(name="code_retour", type="string", length=100, nullable=true)
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(name="time", type="string", length=100, nullable=true)
     */
    private $time;

    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }
}
