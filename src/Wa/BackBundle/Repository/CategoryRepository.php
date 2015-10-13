<?php

namespace Wa\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{

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
}
