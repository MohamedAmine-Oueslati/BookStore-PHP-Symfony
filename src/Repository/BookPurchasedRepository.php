<?php

namespace App\Repository;

use App\Entity\BookPurchased;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookPurchased|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookPurchased|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookPurchased[]    findAll()
 * @method BookPurchased[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookPurchasedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookPurchased::class);
    }

    // /**
    //  * @return BookPurchased[] Returns an array of BookPurchased objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookPurchased
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
