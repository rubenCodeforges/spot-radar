<?php


namespace Codeforges\SpotRadar\SpotApiBundle\Models;

use FOS\OAuthServerBundle\Document\AuthCode as BaseAuthCode;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use FOS\OAuthServerBundle\Model\ClientInterface;

/**
 * @MongoDB\Document
 */
class AuthCode extends BaseAuthCode
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
     * @MongoDB\ReferenceOne(targetDocument="User")
     */
    protected $user;
    
}
