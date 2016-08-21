<?php
namespace Codeforges\CFRest\ApiBundle\Controller;

use Codeforges\CFRest\ApiBundle\ApiBundle;
use Doctrine\Common\Persistence\ObjectRepository;
use FOS\RestBundle\Controller\FOSRestController;

class RestController extends FOSRestController
{
    protected function getBundleRepository(string $repositoryName): ObjectRepository {
        return $this->get('doctrine_mongodb')->getRepository(ApiBundle::$BUNDLE_PATH.'\Document'.$repositoryName);
    }

}