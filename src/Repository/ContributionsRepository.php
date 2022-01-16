<?php

namespace App\Repository;

use App\Entity\Contributions;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contributions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contributions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contributions[]    findAll()
 * @method Contributions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContributionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contributions::class);
    }

    // /**
    //  * @return Contributions[] Returns an array of Contributions objects
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
    public function findOneBySomeField($value): ?Contributions
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getPendingContribs($userID)
    {
        $query = $this->getEntityManager()->createQuery("
        SELECT SUM(c.amount) as sum from App\Entity\contributions c WHERE c.Users = :user AND c.status IN('0','1')
        ")
        ->setParameter(':user', $userID);
        
        return $query->getResult();

      // return $qb->getQuery()->getArrayResult();
        
    }

    public function countContribs($userID)
    {
        $query = $this->getEntityManager()->createQuery("
        SELECT COUNT(c.amount) as count from App\Entity\contributions c WHERE c.Users = :user AND c.status = 2
        ")
        ->setParameter(':user', $userID);
        
        return $query->getResult();
    }

    public function getValidatedContribs($userID)
    {
        $query = $this->getEntityManager()->createQuery("
        SELECT SUM(c.amount) as sum from App\Entity\contributions c WHERE c.Users = :user AND c.status ='2'
        ")
        ->setParameter(':user', $userID);
        
        return $query->getResult();
    }

    public function getValidatedPaidMonth($userID)
    {
        $query = $this->getEntityManager()->createQuery("
        SELECT SUM(c.paidforhowmanymonth) as sum from App\Entity\contributions c WHERE c.Users = :user AND c.status ='2'
        ")
        ->setParameter(':user', $userID);
        
        return $query->getResult();
    }

    public function getAllPendingContribs()
    {
        $query = $this->getEntityManager()->createQuery("
        SELECT c from App\Entity\contributions c WHERE c.status IN ('0','1')
        ");
                
        return $query->getResult();
        
    }

    public function getValidatedofMonth()
    {
        $query = $this->getEntityManager()->createQuery("
        SELECT SUM(c.amount) as sum from App\Entity\contributions c WHERE c.createdmonth='01' AND c.createdyear='2022' AND c.status ='2'  
        ");
                              
        return $query->getResult();;
        
    }

    public function getValidatedofYear()
    {
        $query = $this->getEntityManager()->createQuery("
        SELECT SUM(c.amount) as sum from App\Entity\contributions c WHERE c.createdyear='2022' AND c.status ='2'  
        ");
                              
        return $query->getResult();;
        
    }

    public function takeHand($userid)
    {
        $query = $this->getEntityManager()->createQuery("
        UPDATE App\Entity\contributions c SET c.status = '1' WHERE c.Users = :user  
        ")
        ->setParameter(':user', $userid);   
        return $query->getResult();;
    }

    public function validateContrib($userid, $today, $validator)
    {
        $query = $this->getEntityManager()->createQuery("
        UPDATE App\Entity\contributions c SET c.status = '2', c.validatedby=:validator, c.validated_at=:today WHERE c.Users = :user  
        ")
        ->setParameter(':user', $userid)
        ->setParameter(':today', $today)
        ->setParameter(':validator', $validator);  
        return $query->getResult();
    }

    public function rejectContrib($userid, $today, $validator)
    {
        $query = $this->getEntityManager()->createQuery("
        UPDATE App\Entity\contributions c SET c.status = '3', c.validatedby=:validator, c.validated_at=:today WHERE c.Users = :user  
        ")
        ->setParameter(':user', $userid)
        ->setParameter(':today', $today)
        ->setParameter(':validator', $validator);
        return $query->getResult();
    }

    public function trackRevenue($year)
    {
        $query = $this->getEntityManager()->createQuery("
        SELECT SUM(c.amount) as sum from App\Entity\contributions c WHERE c.createdyear=:year AND c.catfinance='1' AND c.status ='2'  
        ")
        ->setParameter(':year', $year);
                              
        return $query->getResult();
        
    }

    
    
    


}
