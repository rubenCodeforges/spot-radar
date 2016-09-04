<?php
namespace Codeforges\CFRest\ApiBundle\Controller;

use Codeforges\CFRest\ApiBundle\ApiBundle;
use Codeforges\CFRest\ApiBundle\DependencyInjection\AuthService;
use Codeforges\CFRest\ApiBundle\DependencyInjection\UserAuthCredentials;
use Codeforges\CFRest\ApiBundle\Document\User;
use Codeforges\CFRest\ApiBundle\Type\UserType;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @RouteResource("User", pluralize=false)
 */
class UserController extends RestController implements ClassResourceInterface
{

    public function __construct()
    {
        parent::__construct(ApiBundle::$BUNDLE_PATH);
    }

    /**
     * Create a User from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   section = "UserController",
     *   description = "Creates a new user from the submitted data.",
     *  parameters={
     *      {"name"="username", "dataType"="string", "required"=true, "description"="username"},
     *      {"name"="email", "dataType"="string", "required"=true, "description"="valid email"},
     *      {"name"="plain_password", "dataType"="string", "required"=true, "plain password unencoded plain password"},
     *  },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postAction(Request $request){

        $form = $this->createForm(new UserType(), new User());

        return $this
            ->getFormHandler()
            ->processForm($form, $request)
            ->getResponse();
    }

    /**
     * Return the overall user list.
     *
     * @ApiDoc(
     *   resource = true,
     *   section = "UserController",
     *   description = "Return the overall User List",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the user is not found"
     *   }
     * )
     *
     * @View(serializerGroups={"user"})
     */
    public function getAllAction(): Response
    {
        $users = $this->getBundleRepository('User')->findAll();

        $view = $this->view($users, 200);
        return $this->handleView($view);
    }

    /**
     * Returns a auth token for the user, the user will be validated.
     *
     * @ApiDoc(
     *   resource = true,
     *   section = "UserController",
     *   description = "Returns a auth token for the user, the user will be validated",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the marker is not found"
     *   },
     *   requirements={
     *      {
     *          "name"="auth",
     *          "dataType"="base64(json)",
     *          "requirement"="strict",
     *          "description"="A base64 encoded json object {'username': 'value', 'password': 'value' }"
     *      }
     *  },
     * )
     *
     * @QueryParam(name="auth")
     */
    public function loginAction(ParamFetcher $paramFetcher) {
        $authService = $this->get('spot_api.auth_service');

        $params = $authService->getOAuthParams(
            $paramFetcher->get(AuthService::AUTH_PARAM_NAME)
        );

        return $this->redirectToRoute('fos_oauth_server_token', $params);
    }
   
}

