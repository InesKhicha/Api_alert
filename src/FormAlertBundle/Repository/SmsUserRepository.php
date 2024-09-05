<?php 
// src/FormAlertBundle/Repository/ClientRepository.php

namespace FormAlertBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SmsUserRepository extends EntityRepository
{
    public function findByApiKey($apiKey)
    {
        return $this->createQueryBuilder('c')
            ->where('c.api_key = :api_key')
            ->setParameter('api_key', $apiKey)
            ->getQuery()
            ->getOneOrNullResult();
    }
}