<?php

namespace App\Infrastructure\Persistence\Doctrine\Review;

use App\Application\Review\ReadModel\CompanyReviewStats;
use App\Application\Review\ReadModel\ReviewFinderInterface;
use App\Domain\Review\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineReviewFinder implements ReviewFinderInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function findAllOrderedByDate(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('r')
            ->from(Review::class, 'r')
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findCompanyStats(): array
    {
        $rows = $this->entityManager->createQueryBuilder()
            ->select('r.companyName AS companyName, COUNT(r.id) AS reviewCount, AVG(r.rating) AS averageRating')
            ->from(Review::class, 'r')
            ->groupBy('r.companyName')
            ->orderBy('averageRating', 'DESC')
            ->getQuery()
            ->getResult();

        return array_map(
            static fn (array $row) => new CompanyReviewStats(
                companyName: $row['companyName'],
                reviewCount: (int) $row['reviewCount'],
                averageRating: (float) $row['averageRating'],
            ),
            $rows
        );
    }
}
