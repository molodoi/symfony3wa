<?php

namespace Wa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Wa\BackBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Wa\BackBundle\Form\CategoryType;

class CategorieController extends Controller
{
    public function createAction(Request $request){

        $category = new Category();

        $formCategory = $form = $this->createForm(new CategoryType(), $category);

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

            return $this->redirectToRoute('wa_back_categorie_list');

        }

        return $this->render('WaBackBundle:Categorie:create.html.twig',
            array(
                'formCategory' => $formCategory->createView()
            )
        );

    }

    public function editAction(Category $category, Request $request){

        if (!$category) {
            throw new NotFoundHttpException("La catégorie id ".$id." n'existe pas.");
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

            return $this->redirect($this->generateUrl('wa_back_categorie_edit',
                array(
                    'id' => $category->getId()
                )
            ));

        }

        return $this->render('WaBackBundle:Categorie:edit.html.twig',
            array(
                'formCategory' => $formCategory->createView(),
                'category' => $category
            )
        );

    }

    public function listAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('WaBackBundle:Category');

        $categories = $repository->findAll();

        if (null === $categories) {
            throw new NotFoundHttpException("Aucuns categories.");
        }


        return $this->render('WaBackBundle:Categorie:list.html.twig', array('categories' => $categories));

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

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        return $this->render('WaBackBundle:Categorie:show.html.twig',
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

        return $this->redirectToRoute('wa_back_categorie_list');
    }



    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('WaBackBundle:Category')->findAllPerso();

        return $this->render('WaBackBundle:Categorie:index.html.twig', array(
            'categories' => $categories
        ));
    }

    public function getAllCategoriesAction(){
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('WaBackBundle:Category')->findLastCategories();

        return $this->render('WaBackBundle:Categorie/Partials:renderCategories.html.twig', array(
            'categories' => $categories
        ));
    }

}
