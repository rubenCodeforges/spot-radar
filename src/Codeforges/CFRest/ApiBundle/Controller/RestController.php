<?php
namespace Codeforges\CFRest\ApiBundle\Controller;

use Codeforges\CFRest\ApiBundle\ApiBundle;
use Doctrine\Common\Persistence\ObjectRepository;
use FOS\RestBundle\Controller\FOSRestController;

class RestController extends FOSRestController
{
    protected $bundlePath;

    /**
     * RestController constructor.
     * @param $bundlePath
     */
    public function __construct($bundlePath)
    {
        $this->bundlePath = $bundlePath;
    }


    protected function getBundleRepository(string $repositoryName): ObjectRepository {
        return $this->get('doctrine_mongodb')->getRepository($this->bundlePath.'\Document\\'.$repositoryName);
    }

}