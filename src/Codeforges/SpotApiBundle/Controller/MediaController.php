<?php

namespace Codeforges\SpotApiBundle\Controller;
use Codeforges\CFRest\ApiBundle\Controller\RestController;
use Codeforges\SpotApiBundle\Document\Media;
use Codeforges\SpotApiBundle\SpotApiBundle;
use Codeforges\SpotApiBundle\Type\MediaType;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/**
 * @RouteResource("Media", pluralize=false)
 */
class MediaController extends RestController implements ClassResourceInterface
{

    public function __construct()
    {
        parent::__construct(SpotApiBundle::$BUNDLE_PATH);
    }

    public function getAllAction()
    {
        $medias = $this->getBundleRepository('Media')->findAll();
        return $this->getView($medias);
    }

    public function getAction($id)
    {
        $media = $this->getBundleRepository('Media')->find($id);
        return $this->getView($media);
    }

    public function postAction(Request $request)
    {
        $form = $this->createForm(new MediaType(), new Media());

        return $this
            ->getFormHandler()
            ->processForm($form, $request)
            ->getResponse();
    }


    public function deleteAction($id)
    {
        $media = $this->getBundleRepository('Media')->find($id);

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