<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use App\Repository\HabitatRepository;
use App\Repository\ReviewRepository;
use App\Repository\AnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Document\AnimalCount;
use Doctrine\ODM\MongoDB\DocumentManager;


class DefaultController extends AbstractController
{
    private $existinghabitats;

    /**
     * Get habitats list
     *
     * @param HabitatRepository $HabitatRepository
     */
    public function __construct(
        HabitatRepository $HabitatRepository,
    )
    {
        $this->existinghabitats = $HabitatRepository->findAll();
    }


    /**
     * display home page
     *
     * @param HabitatRepository $HabitatRepository
     * @param ServiceRepository $ServiceRepository
     * @param ReviewRepository $reviewRepository
     * @return Response
     */
    #[Route('/')]
    public function home(
        ServiceRepository $ServiceRepository,
        ReviewRepository $reviewRepository,
        AnimalRepository $AnimalRepository,
        DocumentManager $dm,
        ): Response
    {

        foreach($this->existinghabitats as $habitat){
            $habitatImages = $habitat->getHabitat();
            $habitatsName = $habitat->getNom();
            foreach($habitatImages as $image){
                if($image->isCover()){
                    $habitatsImages[$habitatsName] = $image->getImage();
                }
            }
        }

        $allServices = $ServiceRepository->findAll();
        //dd($allServices);
        foreach($allServices as $service){
            $serviceImages = $service->getImage();
            foreach($serviceImages as $serviceImage){
                if($serviceImage->isCover()){
                    $servicesImages[] = $serviceImage->getSlug();
                }
            }
        }
        //dd($servicesImages);

        $reviews = $reviewRepository->findAllValidatedReviewsOrderByDate();
        foreach($reviews as $review){
            $reviewData['date'] = $review->getCreatedAt()->format('d:m:Y');
            $reviewData['grade'] = $review->getNote();
            $reviewData['comment'] = $review->getComment();
            $reviewsByPseudo[$review->getPseudo()] = $reviewData;
        }

        /**
         * get most viewed animal images
         */
        $mostViewedAnimals = $dm->createQueryBuilder(AnimalCount::class)
            ->select('animalId', 'clickCount')
            ->limit(4)
            ->sort('clickCount', 'DESC')
            ->getQuery()
            ->execute();
        $mostViewedAnimalsImages = [];
        foreach($mostViewedAnimals as $animal){
            $animalData = $AnimalRepository->findOneby(['id' => $animal->getAnimalId()]);
            $animalImages = $animalData->getImages();
            foreach($animalImages as $image){
                if($image->isCover()){
                    $mostViewedAnimalsImages[$animal->getAnimalId()] = ['image' => $image->getImage(), 'nom' => $animalData->getFirstname()];
                }
            }
        }

        return $this->render('pages/home.html.twig', [
                            'habitatsImages' => $habitatsImages,
                            'servicesImages' => $servicesImages,
                            'reviews' => $reviewsByPseudo,
                            'habitatsList' => $this->existinghabitats,
                            'imagesAnimaux' => $mostViewedAnimalsImages
                            ]
                            );
    }
    
    /**
     * Display services page
     *
     * @param ServiceRepository $ServiceRepository
     * @return Response
     */
    #[Route('/Services', name:'services')]
    public function service(
        ServiceRepository $ServiceRepository,
        HabitatRepository $HabitatRepository,
        ): Response
    {
        $allServices = $ServiceRepository->findAll();
        $habitats = $HabitatRepository->findAll();
        return $this->render('pages/services.html.twig', [
            'allService' => $allServices,
            'habitatsList' => $this->existinghabitats
            ]
    );
    }
    

    
}