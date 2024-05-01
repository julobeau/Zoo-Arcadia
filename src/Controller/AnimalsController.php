<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\HabitatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Document\AnimalCount;
use Doctrine\ODM\MongoDB\DocumentManager;


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
        string $animal,
        DocumentManager $dm,
        ): Response
    {
        $habitatsList = $HabitatRepository->findAll();
        $animalData = $AnimalRepository->findOneBy(['firstname' => $animal]);

        if(!$animalData) {
            throw $this->createNotFoundException('Pas d\'animal avec le nom ' . $animal);
        }
        else{
            $animalCount = $dm->getRepository(AnimalCount::class)->findOneBy(['animalId' => $animalData->getId()]);
            /**
             * Initialize animal click count document if doesn't exist 
             */
            if (! $animalCount) {
                $animalCount = new AnimalCount();
                $animalCount->setAnimalId($animalData->getId());
                $animalCount->setClickCount(1);
        
                $dm->persist($animalCount);
                $dm->flush();
            }
            /**
             * else increment click count
             */
            else{
                $clickCount = $animalCount->getClickCount();
                $clickCount++;
                $animalCount->setClickCount($clickCount);
                $dm->flush();
            }

            return $this->render('pages/animal.html.twig', [
                'habitatsList' => $habitatsList,
                'biome' => $habitat,
                'animal' => $animalData
            ]);
        }
    }
}
