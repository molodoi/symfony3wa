<?php

namespace Wa\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function findProductByQuanity($quantity = 5){
        $query = $this->getEntityManager()->createQuery(
                "SELECT prod
                FROM WaBackBundle:Product prod
                WHERE prod.quantity < :qty"
            )
            ->setParameter('qty', $quantity);

        return $query->getResult();
    }

    public function findAllPerso(){

        /*
         * Method 1 - SQL style - attention avec $this->getEntityManager()->createQuery()
        return $this->getEntityManager()->createQuery(
            'SELECT p FROM WaBackBundle:Product p'
        )
        ->getResult();
        */


        /*
         * Method 2 - QueryBuilder

        return $this->createQueryBuilder('p')->getQuery()->getResult();
        */


        /*
         * Method 2 - QueryBuilder

        return $this->createQueryBuilder('p')->getQuery()->getResult();

        $qb = $this->createQueryBuilder('p');

        $qb
            ->where('p.id LIKE :id')
            ->setParameter('id', 42)
        ;

        return $qb
            ->getQuery()
            ->getResult()
            ;
        */


        /*
         *  Afficher les produits dont la quantité est inférieur à 5
         *

        $qb = $this->createQueryBuilder('p');

        $qb
            ->where('p.quantity < :quantity')
            ->setParameter('quantity', 5)
        ;

        return $qb
            ->getQuery()
            ->getResult()
            ;
        */


        /*
         *  Afficher le nombre de produit dont la quantité est à 0
         *

        $qb = $this->createQueryBuilder('p');

        $qb
            ->where('p.quantity = :quantity')
            ->setParameter('quantity', 10)
        ;

        return $qb
            ->getQuery()
            ->getResult()
            ;
        */

        /* Afficher le total des prix des produits
        $qb = $this->createQueryBuilder('p');

        $qb->expr()->sum('p.prix');

        return $qb
            ->getQuery()
            ->getResult()
            ;
        */

        /* Afficher la quantité total des produits

        $q = $this->createQueryBuilder('p')
            ->select('SUM(p.quantity) AS qte')
            ->getQuery();

        return $q->getResult();
        //die(dump($q->getResult()));
        */


        /* Afficher le produit le plus cher et le produit le moins cher
        $q = $this->createQueryBuilder('p')
            ->select('p.title')
            ->addSelect('MAX(p.price) AS pmax')
            ->addSelect('MIN(p.price) AS pmin')
            ->getQuery();

        //return $qb->getQuery()->getResult();
        die(dump($q->getResult()));
        */



        /* Afficher le produit le plus cher et ayant la quantité la plus élevé */
        $q = $this->createQueryBuilder('p')
            ->select('p.title')
            ->addSelect('MAX(p.price)')
            ->addSelect('MAX(p.quantity)')
            ->getQuery();

        //return $qb->getQuery()->getResult();
        //return $qb->getQuery()->getResult();
        die(dump($q->getResult()));

    }

    public function findAllProductsWithCategories(){

        /*
         *
         $q = $this->getEntityManager()->createQuery(
            'SELECT prod, cat FROM WaBackBundle:Product prod LEFT JOIN prod.category cat'
            );

            return $q->getResult();
         */


        $q = $this->createQueryBuilder('p')
                ->addSelect('c')
                ->join('p.category', 'c')
                ->getQuery();
        //die(dump($q->getResult()));
        return $q->getResult();
    }


}