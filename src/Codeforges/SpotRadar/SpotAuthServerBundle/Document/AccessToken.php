<?php

namespace Codeforges\SpotRadar\SpotAuthServerBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use FOS\OAuthServerBundle\Document\AccessToken as BaseAccessToken;
use FOS\OAuthServerBundle\Document\ClientInterface;

/**
 * @MongoDB\Document
 */
class AccessToken extends BaseAccessToken
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Client")
     */
    protected $client;

    /**
     * @MongoDB\ReferenceOne(targetDocument="SpotApiBundle/Document/User")
     */
    protected $user;
}   
