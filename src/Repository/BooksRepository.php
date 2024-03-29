<?php

namespace App\Repository;

use App\Entity\Books;
use App\Entity\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Books|null find($id, $lockMode = null, $lockVersion = null)
 * @method Books|null findOneBy(array $criteria, array $orderBy = null)
 * @method Books[]    findAll()
 * @method Books[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Books::class, Search::class);
    }

    // /**
    //  * @return Books[] Returns an array of Books objects
    //  */

    public function findAllQuery(Search $search)
    {
        $query = $this->createQueryBuilder('b');
        if ($search->getMinPrice()) {
            $query = $query->andWhere('b.price > :minprice')
                ->setParameter('minprice', $search->getMinPrice());
        }
        if ($search->getMaxPrice()) {
            $query = $query->andWhere('b.price < :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }
        if ($search->getTitle()) {
            $query = $query->andWhere('b.title LIKE :title')
                ->setParameter('title', '%' . $search->getTitle() . '%');
        }
        return $query->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Books
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
