<?php

namespace App\Domain\Review\Repository;

use App\Domain\Review\Entity\Review;

interface ReviewRepositoryInterface
{
    public function save(Review $review): void;
    public function findById(int $id): ?Review;
}
