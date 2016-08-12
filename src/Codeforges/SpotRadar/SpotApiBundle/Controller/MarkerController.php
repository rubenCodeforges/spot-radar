<?php

namespace Codeforges\SpotRadar\SpotApiBundle\Controller;


use Codeforges\SpotRadar\SpotApiBundle\Model\Marker;


class MarkerController extends SpotRestController
{
    public function getMarkersAction() {
        return  $this->getBundleRepository('\Marker')->findAll();
    }
    
    public function getMarkerAction(Marker $marker) {
        return $marker;
    }

    public function putMarkerAction($type) {
        $marker = new Marker();
        $marker->setType($type);
        $marker->setLocation(array(
            "lat"=> 1.3,
            "lng"=> 1.2
        ));

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($marker);
        $dm->flush();
    }

}