<?php
// src/AppBundle/Repository/CodeValideRepository.php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CodeValideRepository extends EntityRepository
{
    public function findValidCode($codeId)
    {
        return $this->createQueryBuilder('c')
            ->where('c.id = :id')
            ->andWhere('c.expired = false')
            ->setParameter('id', $codeId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
