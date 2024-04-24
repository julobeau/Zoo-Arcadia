<?php

namespace App\Controller;

use App\Entity\Race;
use App\Form\AnimalAddType;
use App\Form\RaceAddType;
use App\Repository\HabitatRepository;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\SecurityBundle\Security;


#[Route('/Dashboard/races', name: 'app_dashboard_races_')]
#[IsGranted('ROLE_USER')]

class DashboardRacesController extends AbstractController
{
    private $existinghabitats;
    private $raceList;

    /**
     * Get habitats list
     *
     * @param HabitatRepository $HabitatRepository
     */
    public function __construct(
        HabitatRepository $HabitatRepository,
        RaceRepository $AnimalRepository,
        private Security $security,
    )
    {
        $this->existinghabitats = $HabitatRepository->findAll();
        $this->raceList = $AnimalRepository->findAll();

    }

    #[Route('/', name: 'show')]
    #[IsGranted('ROLE_USER')]
    public function index(
    ): Response
    {
        if($this->security->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_dashboard_races_add');
        }

        return $this->render('dashboard/races/dashboardRaces.html.twig', [
            'habitatsList' => $this->existinghabitats,
            'races' => $this->raceList,
        ]);
    }

    #[Route('/add', name: 'add', methods:['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function add(
        Request $request,
        EntityManagerInterface $manager,
    ): Response
    {
        $race = new Race();
        $form = $this->createForm(RaceAddType::class, $race);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $race = $form->getData();
            $manager->persist($race);
            $manager->flush();

            $this->addFlash(
                'success',
                'La nouvelle race a été enregistrée.'
            );
            return $this->redirectToRoute('app_dashboard_races_show');
        }

        //$animalsList = $AnimalRepository->findAll();
        return $this->render('dashboard/races/dashboardRaceAdd.html.twig', [
            'habitatsList' => $this->existinghabitats,
            'form' => $form->createView(),
            'races' => $this->raceList,

        ]);
    }

    #[Route('/edit/{id}', name: 'edit', methods:['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(
        Request $request,
        EntityManagerInterface $manager,
        RaceRepository $RaceRepository,
        int $id
    ): Response
    {
        $race = $RaceRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(RaceAddType::class, $race);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $race = $form->getData();
            $manager->persist($race);
            $manager->flush();

            $this->addFlash(
                'success',
                'La race a été modifiée.'
            );
            return $this->redirectToRoute('app_dashboard_races_show');
        }

        //$animalsList = $AnimalRepository->findAll();
        return $this->render('dashboard/races/dashboardRaceEdit.html.twig', [
            'habitatsList' => $this->existinghabitats,
            'form' => $form->createView(),
            'races' => $this->raceList,

        ]);
    }
}
