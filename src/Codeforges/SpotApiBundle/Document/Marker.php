<?php
namespace Codeforges\SpotApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * @MongoDB\Document
 */
class Marker
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $type;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $description;

    /**
     * @MongoDB\Field(type="hash")
     */
    protected $location;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Codeforges\CFRest\ApiBundle\Document\User" , inversedBy="markers")
     */
    protected $user;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Codeforges\SpotApiBundle\Document\Media")
     */
    private $accounts = array();
    public function __construct()
    {
        $this->accounts = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set location
     *
     * @param hash $location
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * Get location
     *
     * @return hash $location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set user
     *
     * @param Codeforges\SpotApiBundle\Document\User $user
     * @return $this
     */
    public function setUser(\Codeforges\SpotApiBundle\Document\User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return Codeforges\SpotApiBundle\Document\User $user
     */
    public function getUser()
    {
        return $this->user;
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
