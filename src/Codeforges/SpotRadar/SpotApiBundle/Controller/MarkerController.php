<?php

namespace Codeforges\SpotRadar\SpotApiBundle\Controller;


use Codeforges\SpotRadar\SpotApiBundle\Models\Marker;
use Codeforges\SpotRadar\SpotApiBundle\SpotApiBundle;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\RequestBodyParamConverter;
use Symfony\Component\HttpFoundation\Request;


class MarkerController extends SpotRestController
{
    public function getMarkersAction() {
        return  $this->getBundleRepository('\Marker')->findAll();
    }
    
    public function getMarkerAction($id) {
        return $this->getBundleRepository('\Marker')->find($id);
    }

    public function putMarkerAction($type, Request $request) {
        $marker = new Marker();
        $marker->setType($type);
        $marker->setDescription($request);
        $marker->setLocation(array(
            "lat"=> 1.3,
            "lng"=> 1.2
        ));

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($marker);
        $dm->flush();
    }

}