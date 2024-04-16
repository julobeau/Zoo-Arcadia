<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\HabitatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Habitats')]

class HabitatsController extends AbstractController
{
    //public $lesHabitats = ['Savane', 'Jungle', 'Marais'];

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
                $otherImages[] = $image->getImage();
            }
        }
        $animals = $habitatData->getAnimals();
        foreach($animals as $animal){
            $AnimalImages = $animal->getImages();
            foreach($AnimalImages as $image){
                echo $image->getImage();
            }
        }
        return $this->render('pages/habitat.html.twig',
        ['titreHabitat' => $habitatData->getNom(),
        'accroche' => $habitatData->getResume(),
        'description' => $habitatData->getDescription(),
        'animals' => $habitatData->getAnimals(),
        'imageCover' => $coverImage,
        'images' => $otherImages
        ]
        );
    }

    /*#[Route('/{habitat}/{animal}', name: 'animal_show')]
    public function showAnimal(
        HabitatRepository $HabitatRepository,
        AnimalRepository $AnimalRepository,
        string $habitat,
        string $animal
        ): Response
    {
        
        $animalData = $AnimalRepository->findOneBy(['firstname' => $animal]);
    

        return $this->render('pages/animal.html.twig');
    }*/
}