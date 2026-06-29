<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    //    /**
    //     * @return Review[] Returns an array of Review objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Review
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<array{company_name: string, review_count: int, avg_rating: float}>
     */
    public function findCompanyStats(): array
    {
        return $this->createQueryBuilder('r')
            ->select('r.company_name, COUNT(r.id) as review_count, AVG(r.rating) as avg_rating')
            ->groupBy('r.company_name')
            ->orderBy('avg_rating', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
