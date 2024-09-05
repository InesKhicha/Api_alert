<?php
// src/FormAlertBundle/Repository/GroupeRepository.php
namespace FormAlertBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GroupeRepository extends EntityRepository
{
    public function findByUserAndId($userId, $id)
    {
        return $this->createQueryBuilder('g')
            ->where('g.user = :userId')
            ->andWhere('g.id = :id')
            ->setParameter('userId', $userId)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult(); // Utiliser getOneOrNullResult pour obtenir un seul résultat ou null
    }
}