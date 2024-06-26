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
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


#[Route('/Dashboard/feeding', name: 'app_dashboard_feeding_')]
#[IsGranted('ROLE_USER')]
class DashboardAnimalFeedingController extends AbstractController
{
    private $existingHabitats;
    private $animalsList;
    private $animalsRapportsList;
    private $nonFedAnimalsReports;


    /**
     * Get habitats and animals lists -- initialize security
     *
     * @param HabitatRepository $HabitatRepository
     * @param AnimalRepository $AnimalRepository
     * @param Securit $security
     */
    public function __construct(
        HabitatRepository $HabitatRepository,
        AnimalRepository $AnimalRepository,
        RapportVeterinaireAnimalRepository $RapportVeterinaireAnimalRepository,
        FoodGivenRepository $FoodGivenRepository,
        private Security $security,
    )
    {
        $this->existingHabitats = $HabitatRepository->findAll();
        $this->animalsList = $AnimalRepository->findAll();
        $this->animalsRapportsList = $RapportVeterinaireAnimalRepository->findAllOrderByDate();
        $today = new \DateTimeImmutable();
        $dayBegin = $today->setTime(00, 00);
        foreach($this->animalsList as $animal){
            $animalLastMeal = $FoodGivenRepository->findOneBy(['animal' => $animal], ['date' => 'DESC']);
            if($animalLastMeal && $animalLastMeal->getDate() < $dayBegin){
                $this->nonFedAnimalsReports[$animal->getId()] = $RapportVeterinaireAnimalRepository->findOneBy(['animal' => $animal->getId()], ['date' => 'DESC']);
            }
            elseif(!$animalLastMeal){
                $this->nonFedAnimalsReports[$animal->getId()] = $RapportVeterinaireAnimalRepository->findOneBy(['animal' => $animal->getId()], ['date' => 'DESC']);
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

    #[IsGranted('ROLE_VETO')]
    #[Route('/overview', name: 'overview')]
    public function overview(
        FoodGivenRepository $FoodGivenRepository,

    ): Response
    {
        $animalsMeals = $FoodGivenRepository->findBy([], ['date' => 'DESC']);

        return $this->render('dashboard/feeding/dashboardFeedingOverview.html.twig', [
            'rapportsAnimals' => $this->animalsRapportsList,
            'habitatsList' => $this->existingHabitats,
            'animalsList' => $this->animalsList,
            'animalsMeals' => $animalsMeals,
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
            $foodGiven = $form->getData();
            $foodGiven->setAnimal($nonFedAnimal);
            $foodGiven->setSoigneur($this->security->getUser());
            $manager->persist($foodGiven);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le nouveau rapport a été enregistré.'
            );
            return $this->redirectToRoute('app_dashboard_feeding_list');

        }

        return $this->render('dashboard/feeding/dashboardFed.html.twig', [
            'rapportsAnimals' => $this->animalsRapportsList,
            'nonFedAnimalsReports' => $this->nonFedAnimalsReports,
            'animalToFeed' => $nonFedAnimal,
            'habitatsList' => $this->existingHabitats,
            'animalsList' => $this->animalsList,
            'form' => $form->createView()
        ]);
    }
}