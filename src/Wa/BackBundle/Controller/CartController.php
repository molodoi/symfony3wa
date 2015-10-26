<?php

namespace Wa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Wa\BackBundle\Controller\BaseController;
use Wa\BackBundle\Entity\Product;

class CartController extends BaseController
{

    public function addAction(Product $product, Request $request){

        // Courage t'es le meilleur ;) !!
        $session = $request->getSession();

        $addProduit = array();

        $qt = 1;

        if($session->has('cart')){
            $addProduit = $session->get('cart');

            if(array_key_exists($product->getId(), $addProduit)){

                $qt = $addProduit[$product->getId()] + 1;

                $addProduit[$product->getId()] = $qt;

            }else{
                $addProduit[$product->getId()] = 1;
            }

            $session->set('cart', $addProduit);

        }else{
            $session->set('cart', $addProduit);
        }


        //$session->remove('cart');

        //die(dump($addProduit));

        return $this->redirectToRoute('wa_back_cart_show');
    }

    public function showAction(Request $request){

        $session = $request->getSession();
        $allProducts = [];

        if($session->get('cart'))
        {
            $em = $this->getDoctrine()->getManager();
            $allProducts = $em->getRepository('WaBackBundle:Product')->findProductByIdProduct(array_keys($session->get('cart')));
        }

        $qty = $session->get('cart');

        foreach($allProducts as $prod){
            $prod->qtyPanier =$qty[$prod->getId()];
        }

        return $this->render('WaBackBundle:Cart:show.html.twig', array(
            'products' => $allProducts,
            'qte' => $qty[$prod->getId()]
        ));
    }

    public function deleteAction(Product $product, Request $request){
        /*$session = $request->getSession();

        $em = $this->getDoctrine()->getManager();

        $em->remove($product);

        $em->flush();

        $allProducts = [];

        if($session->get('cart'))
        {
            $em = $this->getDoctrine()->getManager();
            $allProducts = $em->getRepository('WaBackBundle:Product')->findProductByIdProduct(array_keys($session->get('cart')));
        }

        $qty = $session->get('cart');

        foreach($allProducts as $prod){
            $prod->qtyPanier = $qty[$prod->getId()];
        }


        return $this->render('WaBackBundle:Cart:show.html.twig', array(
            'products' => $allProducts,
            'qte' => $prod->qtyPanier
        ));*/

        $panier = $this->get('wa_back_panier');

        $panier->doDelete();



        //$mkjlk= $panier->doDelete($product);


        return $this->redirectToRoute('wa_back_cart_show');
    }


}