<?php

namespace Codeforges\SpotRadar\SpotApiBundle\Controller;


use Codeforges\SpotRadar\SpotApiBundle\Models\Marker;
use FOS\RestBundle\Controller\FOSRestController;


class MarkerController extends FOSRestController
{
    public function getMarkersAction() {
        $dm = $this->get('doctrine_mongodb')->getRepository('Codeforges\SpotRadar\SpotApiBundle\Models\Marker');
        return $dm->findAll();
    }
    
    public function getMarkerAction($id) {
        
    }

    public function putMarkerAction() {
        $marker = new Marker();
        $marker->setType("PET");
        $marker->setDescription("First marker description");
        $marker->setLocation(array(
            "lat"=> 1.3,
            "lng"=> 1.2
        ));

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($marker);
        $dm->flush();
    }
}