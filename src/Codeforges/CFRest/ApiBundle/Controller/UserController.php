<?php
namespace Codeforges\CFRest\ApiBundle\Controller;

use Codeforges\CFRest\ApiBundle\DependencyInjection\AuthService;
use Codeforges\CFRest\ApiBundle\DependencyInjection\UserAuthCredentials;
use Codeforges\CFRest\ApiBundle\Document\User;
use Codeforges\CFRest\ApiBundle\Model\ValidationMessage;
use Codeforges\CFRest\ApiBundle\Type\UserType;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;

class UserController extends RestController
{
    
    /**
     * register new user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postUsersAction(Request $request){
        
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

