<?php
namespace Codeforges\SpotRadar\SpotApiBundle\Controller;

use Codeforges\SpotRadar\SpotApiBundle\Document\User;
use Codeforges\SpotRadar\SpotApiBundle\Model\ValidationMessage;
use Codeforges\SpotRadar\SpotApiBundle\Type\UserType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;

class UserController extends RestController
{

    /**
     * register new user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postUsersAction(Request $request): JsonResponse{
        
        $dm = $this->get('doctrine_mongodb')->getManager();

        $form = $this->createForm(new UserType(), new User());

        $form->submit($request);

        if ($form->isValid()) {
            $user = $form->getData();

            $dm->persist($user);
            $dm->flush();

            $validationMessage = new ValidationMessage(ValidationMessage::$VALIDATION_SUCCESS);

            return $validationMessage->getResponse(null, [ "email" => $user->getEmail() ]);
        }

        $validationResponse = new ValidationMessage(ValidationMessage::$VALIDATION_ERROR);

        return $validationResponse->getResponse($form);
    }

    /**
     * @View(serializerGroups={"user"})
     */
    public function getUserAllAction(): Response
    {
        $users = $this->getBundleRepository('\User')->findAll();

        $view = $this->view($users, 200);
        return $this->handleView($view);
    }
   
}

