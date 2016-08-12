<?php

namespace Codeforges\SpotRadar\SpotAuthServerBundle\Model;

use FOS\OAuthServerBundle\Document\AccessToken as BaseAccessToken;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use FOS\OAuthServerBundle\Model\ClientInterface;

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
     * @MongoDB\ReferenceOne(targetDocument="SpotApiBundle/Model/User")
     */
    protected $user;
}   
