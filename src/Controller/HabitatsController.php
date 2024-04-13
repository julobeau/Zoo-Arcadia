<?php

namespace App\Controller;

use App\Repository\HabitatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Habitats')]

class HabitatsController extends AbstractController
{
    public $lesHabitats = ['Savane', 'Jungle', 'Marais'];

    #[Route('/')]
    public function habitats(): Response
    {
        return $this->render('pages/habitats.html.twig',
            
        );
    }

    #[Route('/{habitat}', name: 'habitat_show')]
    public function showHabitat(HabitatRepository $HabitatRepository, string $habitat): Response
    {
        $habitatData = $HabitatRepository->findOneBy(['nom' => $habitat]);
        $habitatImages = $habitatData->getHabitat();
        $otherImages = [];
        foreach($habitatImages as $image){
            if($image->isCover()){
                $coverImage = $image->getImage();
            }
            else{
                $otherImages = $image->getImage();
            }
        }
        //dd($habitatData);
        return $this->render('pages/habitat.html.twig',
        ['titreHabitat' => $habitatData->getNom(),
        'accroche' => $habitatData->getResume(),
        'description' => $habitatData->getDescription(),
        'animaux' => $habitatData->getAnimals(),
        'imageCover' => $coverImage,
        'images' => $otherImages
        ]
        );
    }
    
    #[Route('/Jungle')]
    public function jungle(): Response
    {
        return $this->render('pages/habitat.html.twig',
        ['titreHabitat' => 'Jungle']
        );
    }
    
    #[Route('/Marais')]
    public function marais(): Response
    {
        return $this->render('pages/marais.html.twig',
        ['titreHabitat' => 'Marais']
        );
    }
}