<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findById($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.id = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

       public function findOneById($value): ?Article
       {
           return $this->createQueryBuilder('a')
               ->andWhere('a.id = :val')
               ->setParameter('val', $value)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }
}
