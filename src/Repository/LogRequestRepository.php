<?php

namespace App\Repository;

use App\Entity\LogRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LogRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogRequest[]    findAll()
 * @method LogRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogRequestRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LogRequest::class);
    }
}
