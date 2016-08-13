<?php

namespace Codeforges\SpotRadar\SpotAuthServerBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use FOS\OAuthServerBundle\Document\RefreshToken as BaseRefreshToken;

/**
 * @MongoDB\Document
 */
class RefreshToken extends BaseRefreshToken
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
