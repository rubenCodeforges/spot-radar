<?php

namespace Codeforges\SpotRadar\SpotApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use FOS\UserBundle\Document\User as BaseUser;

/**
 * @MongoDB\Document
 * @MongoDBUnique(fields="email")
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id
     */
    protected $id;
}
