<?php

namespace Codeforges\SpotApiBundle\Controller;

use Codeforges\CFRest\ApiBundle\Controller\RestController;
use Codeforges\CFRest\ApiBundle\Model\ValidationMessage;
use Codeforges\SpotApiBundle\Document\Marker;
use Codeforges\SpotApiBundle\SpotApiBundle;
use Codeforges\SpotApiBundle\Type\MarkerType;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;


/**
 * @RouteResource("Marker", pluralize=false)
 */
class MarkerController extends RestController implements ClassResourceInterface
{

    public function __construct()
    {
        parent::__construct(SpotApiBundle::$BUNDLE_PATH);
    }
    
    public function getAllAction()
    {
        $markers = $this->getBundleRepository('Marker')->findAll();
        return $this->getView($markers);
    }

    public function getAction($id)
    {
        $marker = $this->getBundleRepository('Marker')->find($id);
        return $this->getView($marker);
    }

    public function postAction(Request $request)
    {
        $form = $this->createForm(new MarkerType(), new Marker());
        
        return $this
            ->getFormHandler()
            ->processForm($form, $request)
            ->getResponse();
    }

    public function putAction($id, Request $request)
    {
        $marker = $marker = $this->getBundleRepository('Marker')->find($id);
        $form = $this->createForm(new MarkerType(), $marker);
        
        return $this
            ->getFormHandler()
            ->processForm($form, $request)
            ->getResponse();
    }
    
    public function deleteAction($id)
    {
        $marker = $this->getBundleRepository('Marker')->find($id);
        $dm = $this->get('doctrine_mongodb')->getManager();

        $dm->remove($marker);
        $dm->flush();

        return [
            "title" => "delete success",
            "type" => 'Marker removed'
        ];
    }
}
