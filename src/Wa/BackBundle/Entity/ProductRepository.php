<?php

namespace Wa\BackBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
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
            */
            $qb = $this->createQueryBuilder('p');

            $qb
                ->where('p.id LIKE :id')
                ->setParameter('id', 42)
            ;

            return $qb
                ->getQuery()
                ->getResult()
                ;
        }


}