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
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


/**
 * @RouteResource("Marker", pluralize=false)
 */
class MarkerController extends RestController implements ClassResourceInterface
{

    public function __construct()
    {
        parent::__construct(SpotApiBundle::$BUNDLE_PATH);
    }

    /**
     * Return the overall marker list.
     *
     * @ApiDoc(
     *   resource = true,
     *   section = "MarkerController",
     *   description = "Return the overall Marker List",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the marker is not found"
     *   }
     * )
     *
     */
    public function getAllAction()
    {
        $markers = $this->getBundleRepository('Marker')->findAll();
        return $this->getView($markers);
    }

    /**
     * Return an marker identified by markerId.
     *
     * @ApiDoc(
     *   resource = true,
     *   section = "MarkerController",
     *   description = "Return an marker identified by markerId",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the marker is not found"
     *   }
     * )
     *
     * @param string $markerId
     * @return View
     */
    public function getAction($markerId)
    {
        $marker = $this->getBundleRepository('Marker')->find($markerId);
        return $this->getView($marker);
    }

      /**
       * Create a User from the submitted data.<br/>
       *
       * @ApiDoc(
       *   resource = true,
       *   section = "MarkerController",
       *   description = "Creates a new marker from the submitted data.",
       *  parameters={
       *      {"name"="type", "dataType"="string", "required"=true, "description"="marker type"},
       *      {"name"="location", "dataType"="object", "required"=true, "description"="{'lng':'float','lat': 'float'}"},
       *      {"name"="description", "dataType"="string", "required"=false, "description"=""},
       *      {"name"="user", "dataType"="string", "required"=false, "description"="userId to whom the marker belongs"},
       *  },
       *   statusCodes = {
       *     200 = "Returned when successful",
       *     400 = "Returned when the form has errors"
       *   }
       * )
       */
    public function postAction(Request $request)
    {
        $form = $this->createForm(new MarkerType(), new Marker());
        
        return $this
            ->getFormHandler()
            ->processForm($form, $request)
            ->getResponse();
    }

     /**
      * Update a User from the submitted data by ID.<br/>
      *
      * @ApiDoc(
      *   resource = true,
      *   section = "MarkerController",
      *   description = "Updates a marker from the submitted data by ID.",
      *   parameters={
      *      {"name"="type", "dataType"="string", "required"=true, "description"="marker type"},
      *      {"name"="location", "dataType"="object", "required"=true, "description"="{'lng':'float','lat': 'float'}"},
      *      {"name"="description", "dataType"="string", "required"=false, "description"=""},
      *      {"name"="user", "dataType"="string", "required"=false, "description"="userId to whom the marker belongs"},
      *   },
      *   statusCodes = {
      *     200 = "Returned when successful",
      *     400 = "Returned when the form has errors"
      *   }
      * )
      */
    public function putAction($markerId, Request $request)
    {
        $marker = $marker = $this->getBundleRepository('Marker')->find($markerId);
        $form = $this->createForm(new MarkerType(), $marker);
        
        return $this
            ->getFormHandler()
            ->processForm($form, $request)
            ->getResponse();
    }

    /**
     * Delete an marker identified by markerId.
     *
     * @ApiDoc(
     *   resource = true,
     *   section = "MarkerController",
     *   description = "Delete an marker identified by markerId",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the marker is not found"
     *   }
     * )
     *
     * @param string $markerId
     *
     * @return View
     */
    public function deleteAction($markerId)
    {
        $marker = $this->getBundleRepository('Marker')->find($markerId);

        if(!$marker){
            $this->createNotFoundException('Marker not found');
        }
        
        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->remove($marker);
        $dm->flush();

        return [
            "title" => "delete success",
            "type" => 'Marker removed'
        ];
    }
}
