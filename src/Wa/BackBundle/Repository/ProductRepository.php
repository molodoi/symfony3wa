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
        return $q->getResult();

    }

    public function findProductsWithComments($id){
        $q = $this->createQueryBuilder('p')
            ->select('p, c')
            ->join('p.comments', 'c')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->orderBy('p.dateCreated', 'DESC')
            ->setMaxResults(5)
            ->getQuery();
        //die(dump($q->getResult()));
        return $q->getSingleResult();
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

    //Afficher les produits dont la catégorie est "Accueil"
    public function findProductsWhereCategorieIsAccueil(){
        $q = $this->createQueryBuilder('prod')
            ->join('prod.category', 'cat')
            ->where('cat.title = :title')
            ->setParameter('title', 'ACCUEIL')
            ->getQuery();

        return $q->getResult();
    }

    //Afficher les produits qui n'ont pas de catégorie
    public function findProductsDontHaveCategorie(){

        $q = $this->createQueryBuilder('prod')
            ->where('prod.category is null')
            ->getQuery();

        return $q->getResult();

    }

    //Afficher les produits qui n'ont pas de catégorie mais une marque
    public function findProductsDontCatButBrand(){
        $q = $this->createQueryBuilder('prod')
            ->where('prod.category is null', 'prod.brand is not null')
            ->getQuery();

        return $q->getResult();
    }

    //Afficher le nombre de produit par catégorie  (récupérer le titre de la catégorie) Essayer d'afficher cela dans un "camembert"
    public function findCountProductsCategorieId($category_id){
        $q = $this->createQueryBuilder('prod')
            ->select('COUNT(prod) as countProd', 'cat.title')
            ->join('prod.category', 'cat')
            ->addGroupBy('cat.id')
            ->getQuery();
        //die(dump($q->getResult()));
        return $q->getResult();
    }

    // Afficher la catégorie du produit le plus cher sachant que la catégorie doit être active
    public function findProductPriceMaxActiveByCategorie(){
        $q = $this->createQueryBuilder('prod')
            ->select('cat.title')
            ->join('prod.category', 'cat')
            ->where('cat.active = 1')
            ->orderBy('prod.price', 'DESC')
            ->setMaxResults('1')
            ->getQuery();

        return $q->getResult();
    }

    // Afficher le produit dont la description contient le mot "lorem"
    public function findProductWhereDescLorem(){
        $q = $this->createQueryBuilder('prod')
            ->where('prod.description = :lorem')
            ->setParameter('lorem','lorem')
            ->getQuery();

        return $q->getResult();
    }

    public function findProductByIdProduct($idsProduct)
    {
        $query = $this->getEntityManager()->createQuery(
            "
    	SELECT prod
      FROM WaBackBundle:Product prod
      WHERE prod.id IN (:ids)
    "
        )->setParameter('ids', $idsProduct);

        return $query->getResult();
    }



}