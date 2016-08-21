<?php

namespace Codeforges\SpotApiBundle\Controller;

use Codeforges\CFRest\ApiBundle\Controller\RestController;
use Codeforges\SpotApiBundle\SpotApiBundle;
use FOS\RestBundle\Controller\Annotations\View;

class MarkerController extends RestController
{

    public function __construct()
    {
        parent::__construct(SpotApiBundle::$BUNDLE_PATH);
    }

    /**
     * @View(serializerGroups={"marker"})
     */
    public function getMarkersAction()
    {
        $markers = $this->getBundleRepository('Marker')->findAll();
        $view = $this->view($markers, 200);
        return $this->handleView($view);
    }
}
