<?php

namespace App\Application\Review\QueryHandler;

use App\Application\Review\Exception\ReviewNotFoundException;
use App\Application\Review\Query\GetReviewQuery;
use App\Domain\Review\Entity\Review;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final class GetReviewQueryHandler
{
    public function __construct(
        private readonly ReviewRepositoryInterface $reviewRepository,
    ) {
    }

    public function __invoke(GetReviewQuery $query): Review
    {
        return $this->reviewRepository->findById($query->id)
            ?? throw new ReviewNotFoundException(sprintf('Review with id %d not found.', $query->id));
    }
}
