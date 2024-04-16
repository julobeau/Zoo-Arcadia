<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\HabitatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Habitats/{habitat}')]

class AnimalsController extends AbstractController
{
    #[Route('/{animal}', name: 'animal_show')]
    public function showAnimal(
        HabitatRepository $HabitatRepository,
        AnimalRepository $AnimalRepository,
        string $habitat,
        string $animal
        ): Response
    {
        
        $animalData = $AnimalRepository->findOneBy(['firstname' => $animal]);
    

        return $this->render('pages/animal.html.twig', [
            'biome' => $habitat,
            'animal' => $animalData
        ]);
    }
}
