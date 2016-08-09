<?php
namespace Codeforges\SpotRadar\SpotApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations\QueryParam;

class UserController extends SpotRestController
{


    public function confirmAction($token)
    {
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());

        $this->container->get('fos_user.user_manager')->updateUser($user);
        $response = new RedirectResponse($this->container->get('router')->generate('fos_user_registration_confirmed'));
        $this->authenticateUser($user, $response);

        return $response;
    }

    /**
     * @QueryParam(name="page")
     */
    public function postUserAction(ParamFetcher $paramFetcher) {
        return $paramFetcher->get('page');
        //$this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
    }

    /**
     * @QueryParam(name="page")
     */
    public function getUserAction(ParamFetcher $paramFetcher)
    {
        return $paramFetcher;
    }
}

