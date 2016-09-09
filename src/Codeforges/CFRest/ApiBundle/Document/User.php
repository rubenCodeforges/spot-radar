<?php

namespace Codeforges\CFRest\ApiBundle\Document;

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

    /**
     * @MongoDB\ReferenceMany(targetDocument="Codeforges\SpotApiBundle\Document\Marker", mappedBy="user")
     */
    protected $markers;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Codeforges\SpotApiBundle\Document\Media")
     */
    private $accounts = array();

    /**
     * Add marker
     *
     * @param Codeforges\SpotApiBundle\Document\Marker $marker
     */
    public function addMarker(\Codeforges\SpotApiBundle\Document\Marker $marker)
    {
        $this->markers[] = $marker;
    }

    /**
     * Remove marker
     *
     * @param Codeforges\SpotApiBundle\Document\Marker $marker
     */
    public function removeMarker(\Codeforges\SpotApiBundle\Document\Marker $marker)
    {
        $this->markers->removeElement($marker);
    }

    /**
     * Get markers
     *
     * @return \Doctrine\Common\Collections\Collection $markers
     */
    public function getMarkers()
    {
        return $this->markers;
    }

    /**
     * Add account
     *
     * @param Codeforges\SpotApiBundle\Document\Media $account
     */
    public function addAccount(\Codeforges\SpotApiBundle\Document\Media $account)
    {
        $this->accounts[] = $account;
    }

    /**
     * Remove account
     *
     * @param Codeforges\SpotApiBundle\Document\Media $account
     */
    public function removeAccount(\Codeforges\SpotApiBundle\Document\Media $account)
    {
        $this->accounts->removeElement($account);
    }

    /**
     * Get accounts
     *
     * @return \Doctrine\Common\Collections\Collection $accounts
     */
    public function getAccounts()
    {
        return $this->accounts;
    }
}
