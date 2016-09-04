<?php

namespace Codeforges\SpotApiBundle\Controller;
use Codeforges\CFRest\ApiBundle\Controller\RestController;
use Codeforges\SpotApiBundle\Document\Media;
use Codeforges\SpotApiBundle\SpotApiBundle;
use Codeforges\SpotApiBundle\Type\MediaType;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
/**
 * @RouteResource("Media", pluralize=false)
 */
class MediaController extends RestController implements ClassResourceInterface
{

    public function __construct()
    {
        parent::__construct(SpotApiBundle::$BUNDLE_PATH);
    }

    /**
     * Return the overall media list.
     *
     * @ApiDoc(
     *   resource = true,
     *   section = "MediaController",
     *   description = "Return the overall Media List",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the media is not found"
     *   }
     * )
     *
     */
    public function getAllAction()
    {
        $medias = $this->getBundleRepository('Media')->findAll();
        return $this->getView($medias);
    }

    /**
     * Return an media identified by mediaId.
     *
     * @ApiDoc(
     *   resource = true,
     *   section = "MediaController",
     *   description = "Return an media identified by mediaId",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the media is not found"
     *   }
     * )
     *
     * @param string $mediaId
     * @return View
     */
    public function getAction($mediaId)
    {
        $media = $this->getBundleRepository('Media')->find($mediaId);
        return $this->getView($media);
    }

    /**
     * Create a Media from the submitted data.<br/>
     *
     * @ApiDoc(
     *   resource = true,
     *   section = "MediaController",
     *   description = "Creates a new media from the submitted data.",
     *  parameters={
     *      {"name"="file", "dataType"="base64(image)", "required"=true, "description"="image file base64 encoded"},
     *      {"name"="name", "dataType"="string", "required"=true, "description"="File name"},
     *  },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(new MediaType(), new Media());

        return $this
            ->getFormHandler()
            ->processForm($form, $request)
            ->getResponse();
    }

    /**
     * Delete an media identified by mediaId.
     *
     * @ApiDoc(
     *   resource = true,
     *   section = "MediaController",
     *   description = "Delete an media identified by mediaId",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the media is not found"
     *   }
     * )
     *
     * @param string $mediaId
     *
     * @return View
     */
    public function deleteAction($mediaId)
    {
        $media = $this->getBundleRepository('Media')->find($mediaId);

        if(!$media){
            $this->createNotFoundException('Media not found');
        }

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->remove($media);
        $dm->flush();

        return [
            "title" => "delete success",
            "type" => 'Media removed'
        ];
    }
}