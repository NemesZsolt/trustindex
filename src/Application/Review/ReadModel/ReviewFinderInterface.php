<?php

namespace App\Application\Review\ReadModel;

use App\Domain\Review\Entity\Review;

interface ReviewFinderInterface
{
    /** @return Review[] */
    public function findAllOrderedByDate(): array;

    /** @return CompanyReviewStats[] */
    public function findCompanyStats(): array;
}
