<?php

namespace Wa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wa\BackBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategorieController extends Controller
{
    public function createAction(Request $request){

        $category = new Category();

        $formCategory = $this->createFormBuilder($category)
            ->add('title')
            ->add('description')
            ->getForm();

        $formCategory->handleRequest($request);

        if($formCategory->isValid()){

            //$em = $this->get("doctrine");

            $em = $this->getDoctrine()->getManager();

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

    public function editAction($id, Request $request){

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('WaBackBundle:Category')
        ;

        $category = $repository->find($id);

        if (!$category) {
            throw new NotFoundHttpException("La catégorie id ".$id." n'existe pas.");
        }

        $formCategory = $this->createFormBuilder($category)
            ->add('title')
            ->add('description')
            ->getForm();

        $formCategory->handleRequest($request);

        if($formCategory->isValid()){
            //$em = $this->get("doctrine");
            $em = $this->getDoctrine()->getManager();

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

    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('WaBackBundle:Category')
        ;

        $category = $repository->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        return $this->render('WaBackBundle:Categorie:show.html.twig',
            array(
                'categorie' => $category
            )
        );

    }

    public function deleteAction($id, Request $request){

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('WaBackBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $em->remove($category);
        $em->flush();

        $session = $request->getSession();
        $session->getFlashBag()->add('info', $category->getTitle(). ' supprimé');

        return $this->redirectToRoute('wa_back_categorie_list');
    }

}
