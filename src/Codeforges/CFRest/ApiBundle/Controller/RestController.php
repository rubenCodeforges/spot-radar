<?php
namespace Codeforges\CFRest\ApiBundle\Controller;

use Codeforges\CFRest\ApiBundle\ApiBundle;
use Codeforges\CFRest\ApiBundle\Handler\FormHandler;
use Codeforges\CFRest\ApiBundle\Handler\FormHandlerInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use FOS\RestBundle\Controller\FOSRestController;

class RestController extends FOSRestController
{
    protected $bundlePath;
    protected $formHandler;
    
    public function __construct(string $bundlePath)
    {
        $this->bundlePath = $bundlePath;
    }


    protected function getBundleRepository(string $repositoryName): ObjectRepository
    {

        return $this->get('doctrine_mongodb')->getRepository($this->bundlePath.'\Document\\'.$repositoryName);
    }

    protected function getView($document)
    {
        $view = $document ?
            $this->view($document, 200) : $this->getErrorView();
        
        return $this->handleView($view);
    }

    protected function getFormHandler() : FormHandler
    {
        return $this->formHandler ?
            $this->formHandler : $this->createFormHandler();
    }


    private function getErrorView($code = 404 , $message = "Not Found")
    {
        $response = [
            "error"=> [
                "code"=> $code,
                "message"=> $message
            ]
        ];

        return $this->view($response, $code);
    }

    private function createFormHandler(): FormHandler{
        $this->formHandler =  new FormHandler( $this->container->get('doctrine_mongodb')->getManager());

        return $this->formHandler;
    }

}