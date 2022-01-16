<?php

namespace App\Repository;

use App\Entity\Categoryfinances;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categoryfinances|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categoryfinances|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categoryfinances[]    findAll()
 * @method Categoryfinances[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryfinancesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoryfinances::class);
    }

    // /**
    //  * @return Categoryfinances[] Returns an array of Categoryfinances objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Categoryfinances
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
