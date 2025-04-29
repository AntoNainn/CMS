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
    public function findVisibleArticles(int $userId): array
    {
        return $this->createQueryBuilder('a')
        ->join('a.commentaires', 'c')  // Joindre la table Commentaire
        ->andWhere('c.statut = :statut')  // Filtrer les commentaires actifs
        ->setParameter('statut', true)
        ->andWhere('c.user_id != :userId') // Exclure les commentaires appartenant à l'utilisateur donné
        ->setParameter('userId', $userId)
        ->getQuery()
        ->getResult();
    }

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
