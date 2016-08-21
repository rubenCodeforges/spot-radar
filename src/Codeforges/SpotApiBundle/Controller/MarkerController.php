<?php

namespace Codeforges\SpotApiBundle\Controller;

use Codeforges\CFRest\ApiBundle\Controller\RestController;
use Codeforges\SpotApiBundle\SpotApiBundle;

class MarkerController extends RestController
{

    public function __construct()
    {
        parent::__construct(SpotApiBundle::$BUNDLE_PATH);
    }

    public function getMarkersAction()
    {
        return  $this->getBundleRepository('Marker')->findAll();
    }
}
