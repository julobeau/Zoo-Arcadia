<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\ServiceImage;
use App\Form\ServiceAddType;
use App\Repository\ServiceRepository;
use App\Repository\ServiceImageRepository;
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
        ServiceImageRepository $ServiceImageRepository,
    ): Response
    {

        $existingServices = $ServiceRepository->findAll();

        $service = new Service();
        $form = $this->createForm(ServiceAddType::class, $service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service = $form->getData();
            
            if ($photo = $form['photo']->getData()) {
                $filename = $service->getNom().'-'.bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                $photoDir = $this->getParameter('kernel.project_dir').'/assets/images/services';
                $photo->move($photoDir, $filename);
                $serviceImage = new ServiceImage();
                $serviceImage->setSlug($filename);
                $manager->persist($serviceImage);
                $service->addImage($serviceImage);
                $manager->persist($service);
            }
            $manager->flush();

            $this->addFlash(
                'success',
                'Le nouvel service a été enregistré.'
            );

            return $this->redirectToRoute('app_dashboard_services_show');

        }


        return $this->render('dashboard/dashboardServiceAdd.html.twig', [
            'services' => $existingServices,
            'form' => $form->createView()
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