<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\RapportVeterinaireAnimalRepository;
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
    private $rapportsList;


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
        private Security $security,
    )
    {
        $this->existingHabitats = $HabitatRepository->findAll();
        $this->animalsList = $AnimalRepository->findAll();
        $this->rapportsList = $RapportVeterinaireAnimalRepository->findAll();

    }

    #[IsGranted('ROLE_USER')]

    #[Route('/', name: 'show')]
    public function index(
    ): Response
    {
        foreach($this->rapportsList as $rapport){
            $rapportsDates[] = $rapport->getDate()->format('d/m/Y');
        }
        $rapportsUniqueDates = array_unique($rapportsDates);
        return $this->render('dashboard/dashboard_rapport_veterinaire_animal/index.html.twig', [
            'rapports' => $this->rapportsList,
            'habitatsList' => $this->existingHabitats,
            'animalsList' => $this->animalsList,
            'datesRapports' => $rapportsUniqueDates,
        ]);
    }
}
