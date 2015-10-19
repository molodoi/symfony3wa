<?php

namespace Wa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Wa\BackBundle\Entity\Comment;
use Wa\BackBundle\Form\CommentType;

class CommentController extends Controller
{

    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('WaBackBundle:Comment')->findAll();


        return $this->render('WaBackBundle:Comment:index.html.twig',
            array(
                'comments' => $comments,
            )
        );

    }

    public function listAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $allComments = $em->getRepository('WaBackBundle:Comment')->findAll();

        if (null === $allComments) {
            throw new NotFoundHttpException("Aucuns commentaires.");
        }

        if(empty($page)){
            $page = $request->query->getInt('page', 1);
        }

        $paginator = $this->get('knp_paginator');
        $comments = $paginator->paginate(
            $allComments,
            $page,
            5
        );

        return $this->render('WaBackBundle:Comment:index.html.twig',
            array(
                'comments' => $comments,
            )
        );
    }


    public function showAction(Comment $comment, Request $request)
    {
        if (!$comment) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        return $this->render('WaBackBundle:Comment:show.html.twig',
            array(
                'comment' => $comment
            )
        );
    }

    public function editAction(Comment $comment, Request $request)
    {
        if (!$comment) {
            throw new NotFoundHttpException("La catégorie id ".$id." n'existe pas.");
        }

        $formComment = $this->createForm(new CommentType(), $comment);

        $formComment->handleRequest($request);

        if($formComment->isValid()){
            //$em = $this->get("doctrine");

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('wa_back_comment_edit',
                array(
                    'id' => $comment->getId()
                )
            ));

        }

        return $this->render('WaBackBundle:Comment:edit.html.twig',
            array(
                'formComment' => $formComment->createView(),
                'comment' => $comment
            )
        );
    }

    public function createAction(Request $request)
    {

        $comment = new Comment();

        $formComment = $form = $this->createForm(new CommentType(), $comment)
                                ;

        $formComment->handleRequest($request);

        if($formComment->isValid()){

            $em = $this->getDoctrine()->getManager();

            /*
                $image = $category->getImage();
                $image->upload();
                $em->persist($image);
                $em->flush();
            */

            $em->persist($comment);

            $em->flush();


            return $this->redirectToRoute('wa_back_comment_list');

        }

        return $this->render('WaBackBundle:Comment:create.html.twig',
            array(
                'formComment' => $formComment->createView()
            )
        );

    }

    public function deleteAction(Comment $comment, Request $request){

        $em = $this->getDoctrine()->getManager();

        $em->remove($comment);

        $em->flush();

        return $this->redirectToRoute('wa_back_comment_list');
    }

    public function activeAction(Comment $comment, Request $request){

        $em = $this->getDoctrine()->getManager();

        if (!$comment) {
            throw new NotFoundHttpException("Le commentaire id  n'existe pas.");
        }

        if($comment->getActive() == 1){
            $comment->setActive(0);
        }else{
            $comment->setActive(1);
        }

        $em->persist($comment);

        $em->flush();

        if($request->isXmlHttpRequest()){
            return new JsonResponse(array('success' => true));
        }


        return $this->redirectToRoute('wa_back_comment_list');
    }

}
