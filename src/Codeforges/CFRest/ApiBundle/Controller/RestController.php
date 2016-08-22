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

    protected function getView($document)
    {
        $view = $document ?
            $this->view($document, 200) : $this->getErrorView();
        
        return $this->handleView($view);
    }

    private function getErrorView($code = 404 , $message = "Not Found") {
        $response = [
            "error"=> [
                "code"=> $code,
                "message"=> $message
            ]
        ];

        return $this->view($response, $code);
    }

}