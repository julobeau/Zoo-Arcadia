<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalAddType;
use App\Repository\AnimalRepository;
use App\Repository\HabitatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\SecurityBundle\Security;


#[Route('/Dashboard/animals', name: 'app_dashboard_animals_')]
#[IsGranted('ROLE_USER')]
class DashboardAnimalsController extends AbstractController
{
    private $existinghabitats;
    private $animalsList;

    /**
     * Get habitats list
     *
     * @param HabitatRepository $HabitatRepository
     */
    public function __construct(
        HabitatRepository $HabitatRepository,
        AnimalRepository $AnimalRepository,
        private Security $security,
    )
    {
        $this->existinghabitats = $HabitatRepository->findAll();
        $this->animalsList = $AnimalRepository->findAll();

    }

    #[Route('/', name: 'show')]

    #[IsGranted('ROLE_USER')]
    public function index(
    ): Response
    {
        if($this->security->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_dashboard_animals_add');
        }

        return $this->render('dashboard/animals/dashboardAnimals.html.twig', [
            'habitatsList' => $this->existinghabitats,
            'animals' => $this->animalsList,
        ]);
    }
    #[Route('/add', name: 'add', methods:['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function add(
        Request $request,
        EntityManagerInterface $manager,
        AnimalRepository $AnimalRepository,
    ): Response
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalAddType::class, $animal);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $animal = $form->getData();
            $manager->persist($animal);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le nouvel animal a été enregistrée.'
            );
            return $this->redirectToRoute('app_dashboard_animals_show');
        }

        //$animalsList = $AnimalRepository->findAll();
        return $this->render('dashboard/animals/dashboardAnimalAdd.html.twig', [
            'habitatsList' => $this->existinghabitats,
            'animals' => $this->animalsList,
            'form' => $form->createView()

        ]);
    }
}
