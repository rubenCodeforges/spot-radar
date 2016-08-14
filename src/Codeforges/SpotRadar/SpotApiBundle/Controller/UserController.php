<?php
namespace Codeforges\SpotRadar\SpotApiBundle\Controller;

use Codeforges\SpotRadar\SpotApiBundle\Document\User;
use Codeforges\SpotRadar\SpotApiBundle\Model\ValidationMessage;
use Codeforges\SpotRadar\SpotApiBundle\Type\UserType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends RestController
{

    public function postUsersAction(Request $request){
        
        $dm = $this->get('doctrine_mongodb')->getManager();

        $form = $this->createForm(new UserType(), new User());

        $form->submit($request);

        if ($form->isValid()) {
            $user = $form->getData();

            $dm->persist($user);
            $dm->flush();

            $validationMessage = new ValidationMessage(ValidationMessage::$VALIDATION_SUCCESS);

            return $validationMessage->getResponse();
        }

        $validationResponse = new ValidationMessage(ValidationMessage::$VALIDATION_ERROR);

        return $validationResponse->getResponse($form);
    }

    /**
     * @View(serializerGroups={"user"})
     */
    public function getUserAllAction()
    {
        $users = $this->getBundleRepository('\User')->findAll();

        $view = $this->view($users, 200);
        return $this->handleView($view);
    }
   
}

