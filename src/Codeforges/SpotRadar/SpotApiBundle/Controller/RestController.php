<?php
namespace Codeforges\SpotRadar\SpotApiBundle\Controller;

use Codeforges\SpotRadar\SpotApiBundle\SpotApiBundle;
use Doctrine\Common\Persistence\ObjectRepository;
use FOS\RestBundle\Controller\FOSRestController;

class RestController extends FOSRestController
{
    protected function getBundleRepository(string $repositoryName): ObjectRepository {
        return $this->get('doctrine_mongodb')->getRepository(SpotApiBundle::$BUNDLE_PATH.'\Document'.$repositoryName);
    }

}