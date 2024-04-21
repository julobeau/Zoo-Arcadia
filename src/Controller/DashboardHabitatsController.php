<?php

namespace App\Controller;

use App\Entity\Habitat;
use App\Entity\ImagesHabitat;
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
            if ($photo = $form['photos']->getData()) {
                $filename = $habitat->getNom().'-'.bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                $photoDir = $this->getParameter('kernel.project_dir').'/assets/images/habitats/'.$habitat->getNom();
                $photo->move($photoDir, $filename);
                $habitatImage = new ImagesHabitat();
                $habitatImage->setImage($filename);
                $habitatImage->setCover(true);
                $manager->persist($habitatImage);
                $habitat->addHabitat($habitatImage);
            }
            $manager->persist($habitat);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le nouveau service a été enregistré.'
            );
            return $this->redirectToRoute('app_dashboard_habitats_show');
        }

        elseif($form->isSubmitted() && !$form->isValid()){
            echo"ca foire";
            dd($form['photos']);
            $habitat = $form->getData();
            $string = (string) $form->getErrors(true, false);

            $this->addFlash(
                'error',
                $string
            );
            return $this->redirectToRoute('app_dashboard_habitats_show');
        }

        return $this->render('dashboard/dashboardHabitatAdd.html.twig', [
            'habitats' => $existinghabitats,
            'form' => $form->createView()
        ]);
    }
}