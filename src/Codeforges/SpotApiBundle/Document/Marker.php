<?php
namespace Codeforges\SpotApiBundle\Document;

use Codeforges\CFRest\ApiBundle\Document\User;
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
    private $media = array();

    public function __construct()
    {
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
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
    public function setUser(User $user)
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
     * @param Codeforges\SpotApiBundle\Document\Media $media
     */
    public function addMedia(\Codeforges\SpotApiBundle\Document\Media $media)
    {
        $this->media[] = $media;
    }

    /**
     * Remove account
     *
     * @param Codeforges\SpotApiBundle\Document\Media $media
     */
    public function removeMedia(\Codeforges\SpotApiBundle\Document\Media $media)
    {
        $this->media->removeElement($media);
    }

    /**
     * Get accounts
     *
     * @return \Doctrine\Common\Collections\Collection $media
     */
    public function getMedia()
    {
        return $this->media;
    }
}
