<?php
namespace Wa\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wa\BackBundle\Entity\Tag;
/**
 * Marque controller.
 *
 */
class TagController extends BaseController{

    public function cloudTagsAction(){

        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('WaBackBundle:Tag')->findBy(
            array(),       // Critere
            array('title' => 'ASC')
        );

        return $this->render('WaBackBundle:Tag:Partials/cloud-tags.html.twig', array(
            'tags' => $tags
        ));
    }

}