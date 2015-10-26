<?php

namespace Wa\BackBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class Panier
{
    private $em;
    private $session;

    public function __construct(EntityManager $em, Session $session ){
        $this->em = $em;
        $this->session = $session;
    }

    public function doDelete($product){

        $allProducts = [];

        $this->em->remove($product);
        $this->em->flush();

        if($this->session->get('cart'))
        {
            $allProducts = $this->em->getRepository('WaBackBundle:Product')->findProductByIdProduct(array_keys($this->session->get('cart')));
        }

        $qty = $this->session->get('cart');

        foreach($allProducts as $prod){
            $prod->qtyPanier = $qty[$prod->getId()];
        }

        return $allProducts;

    }

    public function getQuantite(){
        return $this->session->get('cart');
    }

    public function getProducts($allProducts){
        return $allProducts;
    }
}