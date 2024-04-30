<?php

namespace App\Controller;

use App\Entity\RapportVeterinaireAnimal;
use App\Entity\RapportVeterinaireHabitat;
use App\Form\RapportVeterinaireAnimalType;
use App\Form\RapportVeterinaireHabitatType;
use App\Repository\AnimalRepository;
use App\Repository\RapportVeterinaireAnimalRepository;
use App\Repository\RapportVeterinaireHabitatRepository;
use App\Repository\HabitatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/dashboard/rapport/veterinaire', name: 'app_dashboard_rapport_veterinaire_')]
#[IsGranted('ROLE_USER')]
class DashboardRapportVeterinaireController extends AbstractController
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

    /**
     * Display reports
     *
     * @return Response
     */
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

    /**
     * Read reports
     *
     * @param AnimalRepository $AnimalRepository
     * @param RapportVeterinaireAnimalRepository $RapportVeterinaireAnimalRepository
     * @param RapportVeterinaireHabitatRepository $RapportVeterinaireHabitatRepository
     * @param string $typeReport
     * @param integer $reportId
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/read/{typeReport}/{reportId}', name: 'readReport', methods:['GET'])]
    public function readReport(
        AnimalRepository $AnimalRepository,
        RapportVeterinaireAnimalRepository $RapportVeterinaireAnimalRepository,
        RapportVeterinaireHabitatRepository $RapportVeterinaireHabitatRepository,
        string $typeReport,
        int $reportId,
    ): Response
    {
        switch ($typeReport){
            case 'animal':
                $reportToRead = $RapportVeterinaireAnimalRepository->findOneBy(['id' => $reportId]);
                //dd($rapport);
                break;
            case 'habitat':
                $reportToRead = $RapportVeterinaireHabitatRepository->findOneBy(['id' => $reportId]);
                //dd($rapport);
                break;
        }
        foreach($this->animalsRapportsList as $rapport){
            $rapportsDates[] = $rapport->getDate()->format('d/m/Y');
        }
        foreach($this->habitatRapportsList as $rapport){
            $rapportsDates[] = $rapport->getCreatedAt()->format('d/m/Y');
        }
        $rapportsUniqueDates = array_unique($rapportsDates);
        arsort($rapportsUniqueDates);

        return $this->render('dashboard/dashboard_rapport_veterinaire_animal/dashboardReportConsult.html.twig', [
            'reportType' => $typeReport,
            'rapport' => $reportToRead,
            'rapportsAnimals' => $this->animalsRapportsList,
            'rapportsHabitats' => $this->habitatRapportsList,
            'habitatsList' => $this->existingHabitats,
            'animalsList' => $this->animalsList,
            'datesRapports' => $rapportsUniqueDates,
        ]);
    }
    
    /**
     * Write animal report
     *
     * @param AnimalRepository $AnimalRepository
     * @param RapportVeterinaireAnimalRepository $RapportVeterinaireAnimalRepository
     * @param RapportVeterinaireHabitatRepository $RapportVeterinaireHabitatRepository
     * @param string $typeReport
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/add/animal', name: 'writeAnimalReport', methods:['GET','POST'])]
    public function writeAnimalReport(
        Request $request,
        EntityManagerInterface $manager,
        AnimalRepository $AnimalRepository,
        RapportVeterinaireAnimalRepository $RapportVeterinaireAnimalRepository,
        RapportVeterinaireHabitatRepository $RapportVeterinaireHabitatRepository,
    ): Response
    {
        $report = new RapportVeterinaireAnimal();

        $form = $this->createForm(RapportVeterinaireAnimalType::class, $report);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $report = $form->getData();
            dd($report);
            $manager->persist($report);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'Le nouveau rapport a été enregistré.'
            );
            return $this->redirectToRoute('app_dashboard_rapport_veterinaire_show');

        }

        elseif($form->isSubmitted() && !$form->isValid()){
            $string = (string) $form->getErrors(true, false);

            $this->addFlash(
                'error',
                $string
            );
            return $this->redirectToRoute('app_dashboard_rapport_veterinaire_writeAnimalReport');
        }

        foreach($this->animalsRapportsList as $rapport){
            $rapportsDates[] = $rapport->getDate()->format('d/m/Y');
        }
        foreach($this->habitatRapportsList as $rapport){
            $rapportsDates[] = $rapport->getCreatedAt()->format('d/m/Y');
        }
        $rapportsUniqueDates = array_unique($rapportsDates);
        arsort($rapportsUniqueDates);

        return $this->render('dashboard/dashboard_rapport_veterinaire_animal/dashboardAnimalReportAdd.html.twig', [
            'rapportsAnimals' => $this->animalsRapportsList,
            'rapportsHabitats' => $this->habitatRapportsList,
            'habitatsList' => $this->existingHabitats,
            'animalsList' => $this->animalsList,
            'datesRapports' => $rapportsUniqueDates,
            'form' => $form->createView()
        ]);
    }
    
    #[IsGranted('ROLE_USER')]
    #[Route('/add/habitat', name: 'writeHabitatReport', methods:['GET','POST'])]
    public function writeHabitatReport(
        Request $request,
        EntityManagerInterface $manager,
        AnimalRepository $AnimalRepository,
        RapportVeterinaireAnimalRepository $RapportVeterinaireAnimalRepository,
        RapportVeterinaireHabitatRepository $RapportVeterinaireHabitatRepository,
    ): Response
    {
        $report = new RapportVeterinaireHabitat();

        $form = $this->createForm(RapportVeterinaireHabitatType::class, $report);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $report = $form->getData();
            dd($report);
            $manager->persist($report);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le nouveau rapport a été enregistré.'
            );
            return $this->redirectToRoute('app_dashboard_rapport_veterinaire_show');

        }

        elseif($form->isSubmitted() && !$form->isValid()){
            $string = (string) $form->getErrors(true, false);

            $this->addFlash(
                'error',
                $string
            );
            return $this->redirectToRoute('app_dashboard_rapport_veterinaire_writeAnimalReport');
        }

        foreach($this->animalsRapportsList as $rapport){
            $rapportsDates[] = $rapport->getDate()->format('d/m/Y');
        }
        foreach($this->habitatRapportsList as $rapport){
            $rapportsDates[] = $rapport->getCreatedAt()->format('d/m/Y');
        }
        $rapportsUniqueDates = array_unique($rapportsDates);
        arsort($rapportsUniqueDates);

        return $this->render('dashboard/dashboard_rapport_veterinaire_animal/dashboardHabitatReportAdd.html.twig', [
            'rapportsAnimals' => $this->animalsRapportsList,
            'rapportsHabitats' => $this->habitatRapportsList,
            'habitatsList' => $this->existingHabitats,
            'animalsList' => $this->animalsList,
            'datesRapports' => $rapportsUniqueDates,
            'form' => $form->createView()
        ]);
    }
}
