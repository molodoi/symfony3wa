<?php

namespace Wa\BackBundle\Repository;

/**
 * RoleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GroupeRepository extends \Doctrine\ORM\EntityRepository
{

    public function findAllGroupe(){
        return $this->createQueryBuilder('g');
    }
}
