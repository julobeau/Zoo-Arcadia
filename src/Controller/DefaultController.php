<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use App\Repository\HabitatRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
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
        HabitatRepository $HabitatRepository,
        ServiceRepository $ServiceRepository,
        ReviewRepository $reviewRepository
        ): Response
    {
        $habitats = $HabitatRepository->findAll();
        foreach($habitats as $habitat){
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
        //dd($reviewsByPseudo);
        return $this->render('pages/home.html.twig',
                            ['habitatsImages' => $habitatsImages,
                            'servicesImages' => $servicesImages,
                            'reviews' => $reviewsByPseudo,
                            'habitatsList' => $habitats
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
            'habitatsList' => $habitats
            ]
    );
    }
    

    
}