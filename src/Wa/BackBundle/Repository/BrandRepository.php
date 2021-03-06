<?php

namespace Wa\BackBundle\Repository;

/**
 * BrandRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BrandRepository extends \Doctrine\ORM\EntityRepository
{

    public function getBrandOrderByTitleAsc(){
        return $this->createQueryBuilder('m')->orderBy('m.title', 'ASC');
    }

    public function allBrandsTags(){
        $q = $this->createQueryBuilder('brand')
            ->select('brand , tag')
            ->leftJoin('brand.tags','tag')
            ->orderBy('brand.id', 'DESC')
            ->getQuery();

        return $q->getResult();
    }

}
