<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Habitats/{habitat}')]

class AnimalsController extends AbstractController
{
    /**
     * Display animal page
     *
     * @param AnimalRepository $AnimalRepository
     * @param string $habitat
     * @param string $animal
     * @return Response
     */
    #[Route('/{animal}', name: 'animal_show')]
    public function showAnimal(
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
