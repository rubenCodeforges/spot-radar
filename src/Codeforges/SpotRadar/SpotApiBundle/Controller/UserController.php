<?php
namespace Codeforges\SpotRadar\SpotApiBundle\Controller;

use Codeforges\SpotRadar\SpotApiBundle\Model\User;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\RestBundle\Controller\Annotations\View;

class UserController extends SpotRestController
{


    public function postUsersAction(ParamFetcher $paramFetcher){
        $userRequest = $paramFetcher->get('user');
        $user = new User();
        $user->setUsername($userRequest["username"]);
        $user->setEmail($userRequest["email"]);

        if(!$userRequest || !$user->getEmail()){
            throw new BadRequestHttpException("No user object");
        }

        $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());

        return Response::HTTP_ACCEPTED;

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

