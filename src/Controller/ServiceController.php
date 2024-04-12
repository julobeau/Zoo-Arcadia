<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/service', name: 'app_api_service_')]

class ServiceController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private ServiceRepository $repository,
        private SerializerInterface $serializer,
        )
    {
    }
    #[Route(name: 'new', methods:'POST')]
    public function new(): Response
    {
        $service = new Service();
        $service->setNom('new service');
        $service->setDescription('une jolie description');
        $service->setCreatedAt(new \DateTimeImmutable());

        $this->manager->persist($service);
        $this->manager->flush();

        return $this->json(
            ['message' => "Service created with {$service->getId()} id"],
            Response::HTTP_CREATED,
        );
    }

    #[Route('/all', name: 'showAll', methods: 'GET')]
    public function showAll(): Response
    {
        $allService = $this->repository->findAll();
        if(!$allService){
            throw new \Exception("Erreur");
        }
        $responseData = $this->serializer->serialize($allService, 'json');
        return new JsonResponse(
            $responseData,
            Response::HTTP_OK
        );
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): Response
    {
        $service = $this->repository->findOneby(['id' => $id]);
        if($service){
            $responseData = $this->serializer->serialize($service, 'json');
            return new JsonResponse($responseData, Response::HTTP_OK);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id): Response
    {
        //$service = aller chercher restaurant id = $id
        if(!$service){
            throw new \Exception("Pas de service avec l'id {$id}");
        }

        $service->setNom('Service name updated');

        return $this->redirectToRoute('app_api_service_show', ['id' => $service->getId()]);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): Response
    {
        //$service = aller chercher restaurant id = $id
        if(!$service){
            throw new \Exception("Pas de service avec l'id {$id}");
        }

        return new JsonResponse(['message' => 'service deleted'], Response::HTTP_NO_CONTENT);
    }

    /*#[Route('api/service', name: 'app_service')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ServiceController.php',
        ]);
    }*/
}
