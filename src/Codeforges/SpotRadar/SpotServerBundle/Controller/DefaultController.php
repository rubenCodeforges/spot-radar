<?php

namespace Codeforges\SpotRadar\SpotServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SpotServerBundle:Default:index.html.twig');
    }
}
