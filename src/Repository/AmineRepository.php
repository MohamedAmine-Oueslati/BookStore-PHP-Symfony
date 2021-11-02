<?php

namespace App\Repository;

use App\Entity\Amine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Amine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Amine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Amine[]    findAll()
 * @method Amine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Amine::class);
    }

    // /**
    //  * @return Amine[] Returns an array of Amine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Amine
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
