<?php
namespace Codeforges\CFRest\ApiBundle\Controller;

use Codeforges\CFRest\ApiBundle\ApiBundle;
use Codeforges\CFRest\ApiBundle\DependencyInjection\AuthService;
use Codeforges\CFRest\ApiBundle\DependencyInjection\UserAuthCredentials;
use Codeforges\CFRest\ApiBundle\Document\User;
use Codeforges\CFRest\ApiBundle\Type\UserType;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;

class UserController extends RestController
{

    public function __construct()
    {
        parent::__construct(ApiBundle::$BUNDLE_PATH);
    }


    /**
     * register new user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postUsersAction(Request $request){

        $form = $this->createForm(new UserType(), new User());

        return $this
            ->getFormHandler()
            ->processForm($form, $request)
            ->getResponse();
    }

    /**
     * @View(serializerGroups={"user"})
     */
    public function getUserAllAction(): Response
    {
        $users = $this->getBundleRepository('User')->findAll();

        $view = $this->view($users, 200);
        return $this->handleView($view);
    }

    /**
     * @QueryParam(name="auth")
     */
    public function loginUserAction(ParamFetcher $paramFetcher) {
        $authService = $this->get('spot_api.auth_service');

        $params = $authService->getOAuthParams(
            $paramFetcher->get(AuthService::AUTH_PARAM_NAME)
        );

        return $this->redirectToRoute('fos_oauth_server_token', $params);
    }
   
}

