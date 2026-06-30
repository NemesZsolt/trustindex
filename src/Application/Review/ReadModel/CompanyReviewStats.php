<?php

namespace App\Application\Review\ReadModel;

final class CompanyReviewStats
{
    public function __construct(
        public readonly string $companyName,
        public readonly int $reviewCount,
        public readonly float $averageRating,
    ) {
    }
}
