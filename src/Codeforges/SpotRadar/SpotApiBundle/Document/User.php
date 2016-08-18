<?php

namespace Codeforges\SpotRadar\SpotApiBundle\Document;

use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

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
