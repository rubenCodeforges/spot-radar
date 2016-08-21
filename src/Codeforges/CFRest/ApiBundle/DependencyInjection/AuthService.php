<?php

namespace Codeforges\CFRest\ApiBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerInterface;

class AuthService
{
    const AUTH_PARAM_NAME = "auth";

    public function __construct(ContainerInterface $containerInterface)
    {
        $this->container = $containerInterface;
    }


    public function getOAuthParams(string $authParams): array
    {   
        $user = $this->decodeUserCredentials($authParams);
        
        $params = [
            "username" => $user->username,
            "password" => $user->password,
            "redirect_uri" => $this->container->getParameter("redirect_uri"),
            "grant_type" => $this->container->getParameter("grant_type"),
            "client_id" => $this->container->getParameter("oauth_client_id"),
            "client_secret" => $this->container->getParameter("oauth_client_secret")
        ];

        return $params;
    }
    
    private function decodeUserCredentials(string $credentials): \stdClass
    {
        $decodedCredentials= base64_decode($credentials);
        return json_decode($decodedCredentials);
    }
}
