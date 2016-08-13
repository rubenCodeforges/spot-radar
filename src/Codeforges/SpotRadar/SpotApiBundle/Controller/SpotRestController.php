<?php
namespace Codeforges\SpotRadar\SpotApiBundle\Controller;

use Codeforges\SpotRadar\SpotApiBundle\SpotApiBundle;
use Doctrine\Common\Persistence\ObjectRepository;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

class SpotRestController extends FOSRestController
{
    protected function getBundleRepository(string $repositoryName): ObjectRepository {
        return $this->get('doctrine_mongodb')->getRepository(SpotApiBundle::$BUNDLE_PATH.'\Document'.$repositoryName);
    }


    protected function getValidationErrorMessages(Form $form): Array
    {
        $errors = [];
        
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                foreach ($form->getErrors(true) as $error) {
                    $errors[$childForm->getName()] = $error->getMessage();
                }
            }
        }

        return $errors;
    }

}