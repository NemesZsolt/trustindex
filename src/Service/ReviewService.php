<?php

namespace App\Service;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;

class ReviewService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Pure domain operation
     * Any additional business rules go here.
     */
    public function create(Review $review): void
    {
        $this->entityManager->persist($review);
        $this->entityManager->flush();
    }
}
