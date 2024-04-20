<?php

namespace App\Controller;

use App\Entity\Habitat;
use App\Form\HabitatAddType;
use App\Repository\HabitatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;




#[Route('/Dashboard/habitat', name: 'app_dashboard_habitats_')]
#[IsGranted('ROLE_USER')]

class DashboardHabitatsController extends AbstractController
{
    #[Route('/', name: 'show', methods: ['GET', 'POST'])]
    public function show(
        Request $request,
        EntityManagerInterface $manager,
        HabitatRepository $HabitatRepository,
    ): Response
    {
        $existinghabitats = $HabitatRepository->findAll();

        $habitat = new Habitat();

        $form = $this->createForm(HabitatAddType::class, $habitat);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $habitat = $form->getData();


            return $this->redirectToRoute('app_dashboard_habitats_show');
        }
            


        return $this->render('dashboard/dashboardHabitatAdd.html.twig', [
            'habitats' => $existinghabitats,
            'form' => $form->createView()
        ]);
    }
}