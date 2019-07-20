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

namespace App\EventListener;

use App\Entity\Journal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use DateTime;

class RequestListener
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }

        $request = $event->getRequest();
        $journal = new Journal();
        $journal->setCode($request->server->get("REDIRECT_STATUS"));
        $journal->setUrl($request->server->get("SCRIPT_URI"));
        $dateTime = new DateTime('now');
        $tempsExcution = $request->server->get("REQUEST_TIME_FLOAT") - $dateTime->getTimestamp();
        $journal->setTime($tempsExcution);
        $this->em->persist($journal);
        $this->em->flush();
    }
}
