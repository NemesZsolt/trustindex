<?php

namespace App\Interface\Http\Form\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateReviewDto
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    public ?string $companyName = null;

    #[Assert\NotBlank]
    #[Assert\Range(min: 1, max: 5)]
    public ?int $rating = null;

    #[Assert\NotBlank]
    public ?string $reviewText = null;
}
