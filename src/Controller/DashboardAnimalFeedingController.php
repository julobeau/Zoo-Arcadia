<?php

namespace App\Controller;

use App\Entity\FoodGiven;
use App\Form\FoodGivenType;
use App\Repository\HabitatRepository;
use App\Repository\AnimalRepository;
use App\Repository\RapportVeterinaireAnimalRepository;
use App\Repository\FoodGivenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


#[Route('/Dashboard/feeding', name: 'app_dashboard_feeding_')]
#[IsGranted('ROLE_EMPLOYEE')]
class DashboardAnimalFeedingController extends AbstractController
{
    private $existingHabitats;
    private $animalsList;
    private $animalsRapportsList;
    private $nonFedAnimalsReports;


    /**
     * Get habitats and animals lists
     *
     * @param HabitatRepository $HabitatRepository
     * @param AnimalRepository $AnimalRepository
     */
    public function __construct(
        HabitatRepository $HabitatRepository,
        AnimalRepository $AnimalRepository,
        RapportVeterinaireAnimalRepository $RapportVeterinaireAnimalRepository,
    )
    {
        $this->existingHabitats = $HabitatRepository->findAll();
        $this->animalsList = $AnimalRepository->findAll();
        $this->animalsRapportsList = $RapportVeterinaireAnimalRepository->findAllOrderByDate();
        $today = new \DateTimeImmutable();
        $dayBegin = $today->setTime(00, 00);
        foreach($this->animalsList as $animal){
            if($animal->getFoodGivens()[0]){
                $animalLastMeal = $animal->getFoodGivens()[0]->getDate();
                if($animalLastMeal < $dayBegin){
                    $this->nonFedAnimalsReports[$animal->getId()] = $RapportVeterinaireAnimalRepository->findOneBy(['animal' => $animal->getId()], ['date' => 'DESC']);
                }
            }
        }

    }

    /**
     * List all non fed animals
     *
     * @param RapportVeterinaireAnimalRepository $RapportVeterinaireAnimalRepository
     * @return Response
     */
    #[IsGranted('ROLE_EMPLOYEE')]
    #[Route('/', name: 'list')]
    public function listAnimals(
        RapportVeterinaireAnimalRepository $RapportVeterinaireAnimalRepository,
    ): Response
    {


        return $this->render('dashboard/feeding/dashboardFeeding.html.twig', [
            'rapportsAnimals' => $this->animalsRapportsList,
            'habitatsList' => $this->existingHabitats,
            'animalsList' => $this->animalsList,
            'nonFedAnimalsReports' => $this->nonFedAnimalsReports,
        ]);
    }

    #[Route('/fed/{id}', name: 'animalFed', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_EMPLOYEE')]
    public function show(
        Request $request,
        AnimalRepository $AnimalRepository,
        FoodGivenRepository $FoodGivenRepository,
        EntityManagerInterface $manager,
        int $id
    ): Response
    {
        $nonFedAnimal = $AnimalRepository->findOneBy(['id' => $id]);
        $foodGiven = new FoodGiven();
        $form = $this->createForm(FoodGivenType::class, $foodGiven);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }

        return $this->render('dashboard/feeding/dashboardFed.html.twig', [
            'rapportsAnimals' => $this->animalsRapportsList,
            'nonFedAnimalsReports' => $this->nonFedAnimalsReports,
            'habitatsList' => $this->existingHabitats,
            'animalsList' => $this->animalsList,
            'form' => $form->createView()
        ]);
    }
}