<?php

namespace App\Repository;

use App\Entity\Paymentmodes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Paymentmodes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paymentmodes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paymentmodes[]    findAll()
 * @method Paymentmodes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentmodesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paymentmodes::class);
    }

    // /**
    //  * @return Paymentmodes[] Returns an array of Paymentmodes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Paymentmodes
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
