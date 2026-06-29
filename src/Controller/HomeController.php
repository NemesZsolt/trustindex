<?php

namespace App\Controller;

use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(ReviewRepository $reviewRepository): Response
    {
        return $this->render('pages/home/index.html.twig', [
            'reviews' => $reviewRepository->findAllOrderedByDate(),
        ]);
    }
}
