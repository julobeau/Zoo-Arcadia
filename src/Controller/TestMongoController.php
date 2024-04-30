<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Document\AnimalCount;
use Doctrine\ODM\MongoDB\DocumentManager;

class TestMongoController extends AbstractController
{
    #[Route('/test/mongo', name: 'app_test_mongo')]
    public function index(
        DocumentManager $dm,
    ): Response
    {
        $animalCount = new AnimalCount();
        $animalCount->setAnimalId(1);
        $animalCount->setClickCount(0);

        $dm->persist($animalCount);
        $dm->flush();

        return new Response('Created product id ' . $animalCount->getId());
    }

    #[Route('/test/mongo/read/{id}', name: 'app_test_mongo')]
    public function read(
        DocumentManager $dm,
        int $id,
    ): Response
    {
        $animalCount = $dm->getRepository(AnimalCount::class)->findOneBy(['animalId' => $id]);

        if (! $animalCount) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }
        else{
            return new Response('Load animalCount id ' . $animalCount->getClickCount());
        }
    }

    #[Route('/test/mongo/update/{id}', name: 'app_test_mongo')]
    public function update(
        DocumentManager $dm,
        int $id,
    ): Response
    {
        $animalCount = $dm->getRepository(AnimalCount::class)->findOneBy(['animalId' => $id]);

        if (! $animalCount) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }
        else{
            $clickCount = $animalCount->getClickCount();
            //dd($clickCount);
            $clickCount++;
            $animalCount->setClickCount($clickCount);
            $dm->flush();
            return new Response('Load animalCount id ' . $animalCount->getClickCount());
        }
    }
}
