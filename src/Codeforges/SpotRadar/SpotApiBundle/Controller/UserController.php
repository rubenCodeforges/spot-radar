<?php
namespace Codeforges\SpotRadar\SpotApiBundle\Controller;

use Codeforges\SpotRadar\SpotApiBundle\Models\User;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
     * @RequestParam(name="user")
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function postUsersAction(User $user) {
//        $request = $paramFetcher->get('user');
//        $user = new User();
        var_dump($user);
        die;
        return $user->getUsername();
        //$this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
    }

    public function getUserAction(ParamFetcher $paramFetcher)
    {
        return $paramFetcher;
    }
}

