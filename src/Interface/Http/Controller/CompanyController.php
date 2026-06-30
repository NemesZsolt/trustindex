<?php

namespace App\Interface\Http\Controller;

use App\Application\Review\ReadModel\ReviewFinderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CompanyController extends AbstractController
{
    #[Route('/companies', name: 'app_companies')]
    public function index(ReviewFinderInterface $reviewRepository): Response
    {
        $stats = $reviewRepository->findCompanyStats();

        return $this->render('pages/company/index.html.twig', [
            'company_stats' => $stats,
        ]);
    }
}
