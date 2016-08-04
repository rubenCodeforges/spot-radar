<?php

namespace Codeforges\SpotRadar\SpotApiBundle\Models;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Client extends BaseClient
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;
    
}
