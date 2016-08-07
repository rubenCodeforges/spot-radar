<?php

namespace Codeforges\SpotRadar\SpotAuthServerBundle\Models;

use FOS\OAuthServerBundle\Document\Client as BaseClient;
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

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
}
