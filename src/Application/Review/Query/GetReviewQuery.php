<?php

namespace App\Application\Review\Query;

final class GetReviewQuery
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
