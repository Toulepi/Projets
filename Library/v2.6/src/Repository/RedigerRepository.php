<?php

namespace App\Repository;

use App\Entity\Rediger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rediger|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rediger|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rediger[]    findAll()
 * @method Rediger[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RedigerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rediger::class);
    }

    // /**
    //  * @return Rediger[] Returns an array of Rediger objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rediger
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
