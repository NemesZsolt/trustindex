<?php

namespace App\Controller;

use App\Entity\Review;
use App\Factory\ReviewFactory;
use App\Form\ReviewType;
use App\Service\ReviewService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ReviewController extends AbstractController
{
    public function __construct(
        private readonly ReviewFactory $reviewFactory,
        private readonly ReviewService $reviewService,
    ) {
    }

    #[Route('/review', name: 'app_review')]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request): Response
    {
        $review = $this->reviewFactory->createFromCurrentUser();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->reviewService->create($review);
            $this->addFlash('success', 'Köszönjük a véleményed!');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/review/add.html.twig', [
            'reviewForm' => $form,
        ]);
    }

    #[Route('/review/{id}', name: 'app_review_detail', requirements: ['id' => '\d+'])]
    public function show(Review $review): Response
    {
        return $this->render('pages/review/detail.html.twig', [
            'review' => $review,
        ]);
    }
}
