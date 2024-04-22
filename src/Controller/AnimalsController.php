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
        HabitatRepository $HabitatRepository,
        string $habitat,
        string $animal
        ): Response
    {
        $habitatsList = $HabitatRepository->findAll();
        $animalData = $AnimalRepository->findOneBy(['firstname' => $animal]);
    

        return $this->render('pages/animal.html.twig', [
            'habitatsList' => $habitatsList,
            'biome' => $habitat,
            'animal' => $animalData
        ]);
    }
}
