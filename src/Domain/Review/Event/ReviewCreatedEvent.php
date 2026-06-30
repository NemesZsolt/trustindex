<?php

namespace App\Domain\Review\Event;

use App\Domain\Review\Entity\Review;

final class ReviewCreatedEvent
{
    public function __construct(
        public readonly Review $review,
        public readonly \DateTimeImmutable $occurredAt = new \DateTimeImmutable(),
    ) {
    }
}
