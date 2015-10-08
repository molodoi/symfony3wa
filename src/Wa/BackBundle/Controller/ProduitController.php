<?php

namespace Wa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wa\BackBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

//use Symfony\Component\HttpFoundation\Response;

class ProduitController extends Controller
{
    public function showAction($id){

        $products = [
            [
                "id" => 1,
                "title" => "Mon premier produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 10
            ],
            [
                "id" => 2,
                "title" => "Mon deuxième produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 20
            ],
            [
                "id" => 3,
                "title" => "Mon troisième produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 30
            ],
            [
                "id" => 4,
                "title" => "",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 410
            ],
        ];

        if (array_key_exists($id, $products)):
                $produit = $products[$id];
        else:
            throw $this->createNotFoundException('Le produit n\'existe pas');
        endif;
        return $this->render('WaBackBundle:Produit:show.html.twig', array('produit' => $produit));
    }

    public function listAction(){
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('WaBackBundle:Product');

        $products = $repository->findAll();

        return $this->render('WaBackBundle:Produit:list.html.twig', array('products' => $products));
    }


    public function createAction(Request $request){

        $product = new Product();

        $formProduct = $this->createFormBuilder($product)
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->add('price', 'number')
            ->add('quantity', 'integer')
            ->add('envoyer', 'submit')
            ->getForm();

        $formProduct->handleRequest($request);

        if($formProduct->isValid()){
            //$em = $this->get("doctrine");
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $session = $request->getSession();
            $session->getFlashBag()->add('info', 'Produit ajouté');

            return $this->redirectToRoute('wa_back_produit_list');

        }

        return $this->render('WaBackBundle:Produit:create.html.twig',
            array(
                'formProduct' => $formProduct->createView()
            ));
    }
}
