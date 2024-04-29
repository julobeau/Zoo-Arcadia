<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\RapportVeterinaireAnimalRepository;
use App\Repository\RapportVeterinaireHabitatRepository;
use App\Repository\HabitatRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/dashboard/rapport/veterinaire/animal', name: 'app_dashboard_rapport_veterinaire_animal_')]
#[IsGranted('ROLE_USER')]
class DashboardRapportVeterinaireAnimalController extends AbstractController
{
    private $existingHabitats;
    private $animalsList;
    private $animalsRapportsList;
    private $habitatRapportsList;


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
        RapportVeterinaireHabitatRepository $RapportVeterinaireHabitatRepository,
        private Security $security,
    )
    {
        $this->existingHabitats = $HabitatRepository->findAll();
        $this->animalsList = $AnimalRepository->findAll();
        $this->animalsRapportsList = $RapportVeterinaireAnimalRepository->findAllOrderByDate();
        $this->habitatRapportsList = $RapportVeterinaireHabitatRepository->findAllOrderByDate();

    }

    #[IsGranted('ROLE_USER')]

    #[Route('/', name: 'show')]
    public function index(
    ): Response
    {
        foreach($this->animalsRapportsList as $rapport){
            $rapportsDates[] = $rapport->getDate()->format('d/m/Y');
        }
        foreach($this->habitatRapportsList as $rapport){
            $rapportsDates[] = $rapport->getCreatedAt()->format('d/m/Y');
        }
        $rapportsUniqueDates = array_unique($rapportsDates);
        arsort($rapportsUniqueDates);
        return $this->render('dashboard/dashboard_rapport_veterinaire_animal/dashboardReport.html.twig', [
            'rapportsAnimals' => $this->animalsRapportsList,
            'rapportsHabitats' => $this->habitatRapportsList,
            'habitatsList' => $this->existingHabitats,
            'animalsList' => $this->animalsList,
            'datesRapports' => $rapportsUniqueDates,
        ]);
    }
}
