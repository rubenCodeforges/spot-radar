<?php
namespace Codeforges\SpotRadar\SpotApiBundle\Controller;

use Codeforges\SpotRadar\SpotApiBundle\Model\User;
use Codeforges\SpotRadar\SpotApiBundle\Type\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;

class UserController extends SpotRestController
{

    public function postUsersAction(Request $request){
        
        $dm = $this->get('doctrine_mongodb')->getManager();

        $form = $this->createForm(new UserType(), new User());

        $form->submit($request);

        if ($form->isValid()) {
            $user = $form->getData();

            $dm->persist($user);
            $dm->flush();

            return new Response(array( "success"=> Response::HTTP_ACCEPTED ), Response::HTTP_ACCEPTED);
        }

        return new Response($form->getErrors(),400);
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

