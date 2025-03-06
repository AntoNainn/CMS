<?php

namespace App\Repository;

use App\Entity\Galerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Galerie>
 */
class GalerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Galerie::class);
    }

    //    /**
    //     * @return Galerie[] Returns an array of Galerie objects
    //     */
       public function findByUserLogin($User): array
       {
           return $this->createQueryBuilder('g')
               ->andWhere('g.user = :val')
               ->setParameter('val', $User)
               ->orderBy('g.id', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

       public function findByPageId($page): array
       {
           return $this->createQueryBuilder('g')
               ->andWhere('g.page = :val')
               ->setParameter('val', $page)
               ->orderBy('g.id', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?Galerie
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
