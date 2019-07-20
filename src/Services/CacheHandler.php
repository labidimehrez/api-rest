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

namespace App\Services;

use DateTime;

/**
 * Description of CacheHandler
 *
 * @author mehrez
 */
class CacheHandler
{
    private function getExpire()
    {
        $expireAt = new DateTime();
        return $expireAt->modify('+600 seconds');
    }

    private function getEtag($request)
    {
        $url = $request->attributes->get('_route');
        return md5($url);
    }

    public function setCacheResponse($response, $request)
    {
        $response->setCache(array(
            'etag' => $this->getEtag($request),
            'last_modified' => new DateTime(),
            'max_age' => 600,
            's_maxage' => 600,
            'private' => false,
            'public' => true,
        ));
        $response->setExpires($this->getExpire());
        return $response;
    }
}
