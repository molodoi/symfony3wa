<?php

namespace Wa\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findLastCategories(){
        $q = $this->createQueryBuilder('v')
            ->setMaxResults(5)
            ->getQuery();
        //die(dump($q->getResult()));
        return $q->getResult();
    }

    public function findAllPerso(){

        $q = $this->createQueryBuilder('c')
            ->select('COUNT(c.id) AS qteCat')
            ->where('c.active = :active')
            ->andWhere('c.active = :inactive')
            ->setParameter('active', '1')
            ->setParameter('inactive', '0')
            ->getQuery();

        //return $q->getResult();
        die(dump($q->getSingleResult()));

    }

    public function getCategoriesOrderByPosition(){
        return $this->createQueryBuilder('cat')->orderBy('cat.position');
    }


    // Afficher les catégories n'ayant pas d'image
    public function findCategoriesWithoutImage(){
        $q = $this->createQueryBuilder('cat')
            ->where('cat.image is null')

        ->getQuery();
        //die(dump($q->getQuery()));
        //die(dump($q->getResult()));

        return $q->getResult();
    }


    // Afficher la légende de l'image dont la position de la catégorie est la plus élevée
    public function findImageCaptionWherePositionIsMax(){
        $q = $this->createQueryBuilder('cat')
            ->select('img.caption')
            ->join('cat.image', 'img')
            ->orderBy('cat.position', 'DESC')
            ->setMaxResults('1')
            ->getQuery();
        //die(dump($q->getQuery()));

        return $q->getResult();
    }
    // Afficher l'image de la catégorie dont le l'id du produit est 1 (faire en sorte que l'id soit dynamique)
    public function findImageCategorieWhereProductWhereId($id){
        $q = $this->createQueryBuilder('cat')
            ->select('img')
            ->join('cat.image', 'img')
            ->join('prod.category', 'prod')
            ->where('prod.id = :id')
            ->setParameter('id', $id)
            ->setMaxResults('1')
            ->getQuery();
        //die(dump($q->getQuery()));

        return $q->getSingleResult();
    }

    // Afficher la catégorie dont la légende de l'image est la plus grande
    public function findCategorieWhereMaxlenghtCaption(){
        $q = $this->createQueryBuilder('cat')
            ->join('cat.image', 'img')
            ->orderBy('img.caption', 'DESC')
            ->setMaxResults('1')
            ->getQuery();
        //die(dump($q->getQuery()));

        return $q->getSingleResult();
    }

}