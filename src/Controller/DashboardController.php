<?php

namespace App\Controller;

use App\Repository\HabitatRepository;
use App\Repository\AnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Document\AnimalCount;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;


#[Route('/Dashboard', name: 'app_dashboard')]
#[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{
    /**
     * Display dashboard
     *
     * @return Response
     */
    #[Route('/', name: '_general')]
    #[IsGranted('ROLE_USER')]
    public function index(
        ChartBuilderInterface $chartBuilder,
        HabitatRepository $HabitatRepository,
        DocumentManager $dm,
        AnimalRepository $AnimalRepository,
    ): Response
    {

        $mostViewedAnimals = $dm->createQueryBuilder(AnimalCount::class)
            ->select('animalId', 'clickCount')
            ->sort('clickCount', 'DESC')
            ->getQuery()
            ->execute();

        foreach($mostViewedAnimals as $animal){
            $labels[] = $AnimalRepository->findOneBy(['id' => $animal->getAnimalId()])->getFirstname();
            $data[] = $animal->getClickCount();
            $chartScale = max($data)*2;
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);

        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Nombre de consultations',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    'borderColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    'borderWidth' => 1,
                    'barThickness' => 30,
                    'maxBarThickness' => 50,
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => $chartScale,
                    'title' => [
                        'display' => true,
                        'text' => 'clicks',
                    ],
                ],
                'x' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => count($data),
                    'title' => [
                        'display' => true,
                        'text' => 'Animaux',
                    ],
                ],
            ],
        ]);

        $habitatsList = $HabitatRepository->findAll();
        return $this->render('dashboard/utils/dashboardAnimalsChart.html.twig', [
            'habitatsList' => $habitatsList,
            'chart' => $chart,
            'controller_name' => 'utils/DashboardController',
        ]);
    }
}
