<?php

namespace Wa\BackBundle\Repository;

/**
 * TagRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TagRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllTags(){
        return $this->createQueryBuilder('t')->orderBy('t.title', 'ASC');
    }



    public function allTagsBrands(){
        $q = $this->createQueryBuilder('tag')
            ->select('tag , brand')
            ->leftJoin('tag.brands','brand')
            ->orderBy('tag.id', 'DESC')
            ->getQuery();

        return $q->getResult();
    }

}
