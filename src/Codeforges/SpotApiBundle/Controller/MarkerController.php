<?php

namespace Codeforges\SpotApiBundle\Controller;

use Codeforges\CFRest\ApiBundle\Controller\RestController;
use Codeforges\CFRest\ApiBundle\Model\ValidationMessage;
use Codeforges\SpotApiBundle\Document\Marker;
use Codeforges\SpotApiBundle\SpotApiBundle;
use Codeforges\SpotApiBundle\Type\MarkerType;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
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
        $dm = $this->get('doctrine_mongodb')->getManager();

        $form = $this->createForm(new MarkerType(), new Marker());

        $form->submit($request);

        if ($form->isValid()) {
            $marker = $form->getData();

            $dm->persist($marker);
            $dm->flush();

            $validationMessage = new ValidationMessage(ValidationMessage::$VALIDATION_SUCCESS);

            return $validationMessage->getResponse();
        }

        $validationResponse = new ValidationMessage(ValidationMessage::$VALIDATION_ERROR);

        return $validationResponse->getResponse($form);
    }

    public function putAction(Marker $marker)
    {
        
    }
}
