<?php

namespace Wa\BackBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Wa\BackBundle\Entity\Product;

class Cart
{
    private $em;
    private $session;

    public function __construct(EntityManager $em, Session $session ){
        $this->em = $em;
        $this->session = $session;
    }

    public function doDelete(Product $product){

        $addProduit = array();

        $qt = 1;

        if($this->session->has('cart')){
            $addProduit = $this->session->get('cart');

            if(array_key_exists($product->getId(), $addProduit)){

                $qt = $addProduit[$product->getId()] - 1;

                if( $qt <= 0 ){
                    unset($addProduit[$product->getId()]);
                }else{
                    $addProduit[$product->getId()] = $qt;
                }
            }else{
                $addProduit[$product->getId()] = $qt;
            }

            $this->session->set('cart', $addProduit);

        }else{
            $this->session->set('cart', $addProduit);
        }

    }

    public function addCart(Product $product, $qt = 1){

        $addProduit = array();

        $qt = 1;

        if($this->session->has('cart')){
            $addProduit = $this->session->get('cart');

            if(array_key_exists($product->getId(), $addProduit)){

                $qt = $addProduit[$product->getId()] + 1;

                $addProduit[$product->getId()] = $qt;

            }else{
                $addProduit[$product->getId()] = 1;
            }

            $this->session->set('cart', $addProduit);

        }else{
            $this->session->set('cart', $addProduit);
        }
    }

    public function getQuantite(){
        return $this->session->get('cart');
    }

    public function getProducts($allProducts){
        return $allProducts;
    }
}