<?php

namespace App\Repository;

use App\Entity\Commentaire;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commentaire>
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    //    /**
    //     * @return Commentaire[] Returns an array of Commentaire objects
    //     */
       public function findByIdArticle($value): array
       {
           return $this->createQueryBuilder('c')
               ->andWhere('c.article = :val')
               ->setParameter('val', $value)
               ->orderBy('c.id', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?Commentaire
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findCommentsForArticle(int $articleId, int $userId): array
    {
        return $this->createQueryBuilder('c')
        ->where('c.article = :article')
        ->andWhere(
            'c.statut = TRUE OR (c.statut = FALSE AND c.user = :user)'
        )
        ->setParameter('article', $articleId)
        ->setParameter('user', $userId)
        ->getQuery()
        ->getResult();
        
        dd($qb->getQuery()->getDQL());
    }
}
