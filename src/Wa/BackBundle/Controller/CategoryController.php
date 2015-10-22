<?php

namespace Wa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Wa\BackBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Wa\BackBundle\Controller\BaseController;
use Wa\BackBundle\Form\CategoryType;

class CategoryController extends BaseController
{
    public function createAction(Request $request){

        $this->breadcrumbs(
            array('Catégories' => $this->generateUrl("wa_back_category_create")), ''
        );

        $category = new Category();

        $formCategory = $this->createForm(new CategoryType(), $category);

        $formCategory->handleRequest($request);

        if($formCategory->isValid()){

            $em = $this->getDoctrine()->getManager();

            /*
                $image = $category->getImage();
                $image->upload();
                $em->persist($image);
                $em->flush();
            */

            $em->persist($category);

            $em->flush();

            $session = $request->getSession();

            $session->getFlashBag()->add('info', 'Catégorie ajouté');

            return $this->redirectToRoute('wa_back_category_list');

        }

        return $this->render('WaBackBundle:Category:create.html.twig',
            array(
                'formCategory' => $formCategory->createView()
            )
        );

    }

    public function editAction(Category $category, Request $request){

        $this->breadcrumbs(
            array('Catégories' => $this->generateUrl("wa_back_category_list")), ''
        );

        if (!$category) {
            throw new NotFoundHttpException("La catégorie id n'existe pas.");
        }

        $formCategory = $this->createForm(new CategoryType(), $category);

        $formCategory->handleRequest($request);

        if($formCategory->isValid()){
            //$em = $this->get("doctrine");

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $session = $request->getSession();

            $session->getFlashBag()->add('info', $category->getTitle(). ' modifié');

            return $this->redirect($this->generateUrl('wa_back_category_edit',
                array(
                    'id' => $category->getId()
                )
            ));

        }

        return $this->render('WaBackBundle:Category:edit.html.twig',
            array(
                'formCategory' => $formCategory->createView(),
                'category' => $category
            )
        );

    }

    public function listAction(Request $request, $page)
    {
        $this->breadcrumbs(
            array('Catégories' => $this->generateUrl("wa_back_category_list")), ''
        );



        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('WaBackBundle:Category');

        $allCategories = $repository->findAll();

        if (null === $allCategories) {
            throw new NotFoundHttpException("Aucuns categories.");
        }

        if(empty($page)){
            $page = $request->query->getInt('page', 1);
        }

        $paginator = $this->get('knp_paginator');
        $categories = $paginator->paginate(
            $allCategories,
            $page,
            5
        );



        return $this->render('WaBackBundle:Category:list.html.twig', array('categories' => $categories));

    }

    public function showAction(Category $category, Request $request)
    {
        /*
        $em = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('WaBackBundle:Category')
        ;


        $category = $repository->find($id);
        */


        $this->breadcrumbs(
            array('Catégories' => $this->generateUrl("wa_back_category_list")), ''
        );

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        return $this->render('WaBackBundle:Category:show.html.twig',
            array(
                'categorie' => $category
            )
        );

    }


    public function deleteAction(Category $category,  Request $request){

        $em = $this->getDoctrine()->getManager();

        $title = $category->getTitle();

        $em->remove($category);

        $em->flush();

        $session = $request->getSession();
        $session->getFlashBag()->add('info', $title. ' supprimé');

        return $this->redirectToRoute('wa_back_category_list');
    }



    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('WaBackBundle:Category')->findAllPerso();

        return $this->render('WaBackBundle:Category:index.html.twig', array(
            'categories' => $categories
        ));
    }

    public function getAllCategoriesAction(){
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('WaBackBundle:Category')->findLastCategories();

        return $this->render('WaBackBundle:Category/Partials:renderCategories.html.twig', array(
            'categories' => $categories
        ));
    }
    
    public function activeAction(Category $category, Request $request){

        $em = $this->getDoctrine()->getManager();

        if (!$category) {
            throw new NotFoundHttpException("La catégorie id n'existe pas.");
        }

        if($category->getActive() == 1){
            $category->setActive(0);
        }else{
            $category->setActive(1);
        }

        $em->persist($category);

        $em->flush();

        if($request->isXmlHttpRequest()){
            return new JsonResponse(array('success' => true));
        }


        return $this->redirectToRoute('wa_back_category_list');
    }

}
