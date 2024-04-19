<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;




#[Route('/Dashboard/services', name: 'app_dashboard_services_')]
#[IsGranted('ROLE_USER')]

class DashboardServicesController extends AbstractController
{
    #[Route('/', name: 'show', methods: ['GET', 'POST'])]
    public function service(
        Request $request,
        EntityManagerInterface $manager,
        ServiceRepository $ServiceRepository,
    ): Response
    {

        $existingServices = $ServiceRepository->findAll();

        return $this->render('dashboard/dashboardServices.html.twig', [
            'services' => $existingServices,
            //'form' => $form->createView()
        ]);
    }
    
    #[Route('/show', name: 'showService', methods: ['GET'])]
    public function show(
        Request $request,
        EntityManagerInterface $manager,
        ServiceRepository $ServiceRepository,
    ): Response
    {

        $existingServices = $ServiceRepository->findAll();

        return $this->render('dashboard/dashboardServices.html.twig', [
            'services' => $existingServices,
            //'form' => $form->createView()
        ]);
    }
    
    #[Route('/show', name: 'deleteService', methods: ['GET'])]
    public function delete(
        Request $request,
        EntityManagerInterface $manager,
        ServiceRepository $ServiceRepository,
    ): Response
    {

        $existingServices = $ServiceRepository->findAll();

        return $this->render('dashboard/dashboardServices.html.twig', [
            'services' => $existingServices,
            //'form' => $form->createView()
        ]);
    }
    
    #[Route('/edit', name: 'editService', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $manager,
        ServiceRepository $ServiceRepository,
    ): Response
    {

        $existingServices = $ServiceRepository->findAll();

        return $this->render('dashboard/dashboardServices.html.twig', [
            'services' => $existingServices,
            //'form' => $form->createView()
        ]);
    }
}