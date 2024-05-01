<?php

namespace App\Controller;

use App\Repository\HabitatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Document\AnimalCount;
use Doctrine\ODM\MongoDB\DocumentManager;



#[Route('/Dashboard', name: 'app_dashboard')]
#[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{
    /**
     * Display dashboard
     *
     * @return Response
     */
    #[Route('/', name: '_general')]
    #[IsGranted('ROLE_USER')]
    public function index(
        HabitatRepository $HabitatRepository,
    ): Response
    {
        $habitatsList = $HabitatRepository->findAll();
        return $this->render('dashboard/dashboard.html.twig', [
            'habitatsList' => $habitatsList,
            'controller_name' => 'DashboardController',
        ]);
    }
}
