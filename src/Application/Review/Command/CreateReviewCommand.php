<?php

namespace App\Application\Review\Command;

final class CreateReviewCommand
{
    public function __construct(
        public readonly string $authorEmail,
        public readonly string $companyName,
        public readonly int $rating,
        public readonly string $reviewText,
    ) {
    }
}
