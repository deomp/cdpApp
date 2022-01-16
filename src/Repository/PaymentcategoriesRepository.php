<?php

namespace App\Repository;

use App\Entity\Paymentcategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Paymentcategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paymentcategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paymentcategories[]    findAll()
 * @method Paymentcategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentcategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paymentcategories::class);
    }

    // /**
    //  * @return Paymentcategories[] Returns an array of Paymentcategories objects
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
    public function findOneBySomeField($value): ?Paymentcategories
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
