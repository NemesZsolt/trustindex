<?php

namespace App\Interface\Http\Controller;

use App\Application\Review\Command\CreateReviewCommand;
use App\Application\Review\Exception\ReviewNotFoundException;
use App\Application\Review\Query\GetReviewQuery;
use App\Interface\Http\Form\Dto\CreateReviewDto;
use App\Interface\Http\Form\ReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ReviewController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly MessageBusInterface $queryBus,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/review', name: 'app_review')]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request): Response
    {
        $dto = new CreateReviewDto();
        $form = $this->createForm(ReviewType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserInterface $user */
            $user = $this->getUser();

            $this->commandBus->dispatch(new CreateReviewCommand(
                authorEmail: $user->getUserIdentifier(),
                companyName: $dto->companyName,
                rating: $dto->rating,
                reviewText: $dto->reviewText,
            ));

            $this->addFlash('success', 'Köszönjük a véleményed!');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/review/add.html.twig', [
            'reviewForm' => $form,
        ]);
    }

    #[Route('/review/{id}', name: 'app_review_detail', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        try {
            $review = $this->queryBus
                ->dispatch(new GetReviewQuery($id))
                ->last(HandledStamp::class)
                ->getResult();
        } catch (HandlerFailedException $e) {
            if ($e->getNestedExceptionOfClass(ReviewNotFoundException::class)) {
                throw $this->createNotFoundException('Review not found.', $e);
            }

            throw $e;
        }

        return $this->render('pages/review/detail.html.twig', [
            'review' => $review,
        ]);
    }
}
