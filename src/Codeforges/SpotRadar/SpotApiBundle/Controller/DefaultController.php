<?php

namespace Codeforges\SpotRadar\SpotApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SpotApiBundle:Default:index.html.twig');
    }
}
