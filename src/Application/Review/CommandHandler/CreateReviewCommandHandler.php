<?php

namespace App\Application\Review\CommandHandler;

use App\Application\Review\Command\CreateReviewCommand;
use App\Domain\Review\Entity\Review;
use App\Domain\Review\Event\ReviewCreatedEvent;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class CreateReviewCommandHandler
{
    public function __construct(
        private readonly ReviewRepositoryInterface $reviewRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(CreateReviewCommand $command): void
    {
        $review = new Review();
        $review->setAuthorEmail($command->authorEmail);
        $review->setCompanyName($command->companyName);
        $review->setRating($command->rating);
        $review->setReviewText($command->reviewText);

        $this->reviewRepository->save($review);

        $this->eventDispatcher->dispatch(new ReviewCreatedEvent($review));
    }
}
