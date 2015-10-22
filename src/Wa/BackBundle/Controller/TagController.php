<?php
namespace Wa\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Wa\BackBundle\Entity\Tag;
use Wa\BackBundle\Form\TagType;

/**
 * Marque controller.
 *
 */
class TagController extends BaseController{

    public function createAction(Request $request){
        $this->breadcrumbs(
            array('Tags' => $this->generateUrl("wa_back_tag_create")), ''
        );

        $tag = new Tag();

        $formTag = $this->createForm(new TagType(), $tag);

        $formTag->handleRequest($request);

        if($formTag->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($tag);

            $em->flush();

            return $this->redirectToRoute('wa_back_tag_list');

        }

        return $this->render('WaBackBundle:Tag:create.html.twig',
            array(
                'formTag' => $formTag->createView()
            )
        );


    }

    public function listAction(Request $request, $page){
        $this->breadcrumbs(
            array('Tags' => $this->generateUrl("wa_back_tag_list")), ''
        );

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('WaBackBundle:Tag');

        $allTags = $repository->allTagsBrands();


        if (null === $allTags) {
            throw new NotFoundHttpException("Aucuns categories.");
        }

        if(empty($page)){
            $page = $request->query->getInt('page', 1);
        }

        $paginator = $this->get('knp_paginator');
        $tags = $paginator->paginate(
            $allTags,
            $page,
            5
        );

        return $this->render('WaBackBundle:Tag:list.html.twig', array('tags' => $tags));

    }

    public function showAction(Tag $tag, Request $request){
        $this->breadcrumbs(
            array('Tags' => $this->generateUrl("wa_back_tag_list")), ''
        );

        if (!$tag) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        return $this->render('WaBackBundle:Tag:show.html.twig',
            array(
                'tag' => $tag
            )
        );
    }

    public function editAction(Tag $tag, Request $request){
        $this->breadcrumbs(
            array('Tags' => $this->generateUrl("wa_back_tag_list")), ''
        );

        if (!$tag) {
            throw new NotFoundHttpException("Le tag id n'existe pas.");
        }

        $formTag = $this->createForm(new TagType(), $tag);

        $formTag->handleRequest($request);

        if($formTag->isValid()){
            //$em = $this->get("doctrine");

            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            $session = $request->getSession();

            $session->getFlashBag()->add('info', $tag->getTitle(). ' modifié');

            return $this->redirect($this->generateUrl('wa_back_tag_edit',
                array(
                    'id' => $tag->getId()
                )
            ));

        }

        return $this->render('WaBackBundle:Tag:edit.html.twig',
            array(
                'formTag' => $formTag->createView(),
                'tag' => $tag
            )
        );
    }

    public function deleteAction(Tag $tag, Request $request){

        $em = $this->getDoctrine()->getManager();

        $title = $tag->getTitle();

        $em->remove($tag);

        $em->flush();

        $session = $request->getSession();

        $session->getFlashBag()->add('info', $title. ' supprimé');

        return $this->redirectToRoute('wa_back_tag_list');
    }

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