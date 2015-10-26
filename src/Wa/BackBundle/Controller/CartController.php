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

        $panier = $this->get('wa_back_panier');

        $panier->addCart($product);

        return $this->redirectToRoute('wa_back_cart_show');


    }

    public function showAction(Request $request){
        $session = $request->getSession();
        //$session->remove('cart');

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
            'products' => $allProducts
        ));
    }

    public function deleteAction(Product $product, Request $request){

        $panier = $this->get('wa_back_panier');

        $panier->doDelete($product);

        return $this->redirectToRoute('wa_back_cart_show');
    }


}