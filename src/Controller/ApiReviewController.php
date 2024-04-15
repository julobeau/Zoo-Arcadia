<?php

namespace App\Controller;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/review', name:'app_api_review_')]
class ApiReviewController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private ReviewRepository $repository,
        private SerializerInterface $serializer,
        )
    {
    }
    #[Route(name: 'new', methods:['POST'] )]
    public function addReview(Request $request): Response
    {
        //$review = new Review();
        $review = $this->serializer->deserialize($request->getContent(), Review::class, 'json');
        dd($review);
        $review->setPseudo('new service');
        $review->setNote('new service');

        $review->setComment('une jolie description');
        $review->setCreatedAt(new \DateTimeImmutable());

        $this->manager->persist($review);
        $this->manager->flush();

        return $this->json(
            ['message' => "Review created with {$review->getId()} id"],
            Response::HTTP_CREATED,
        );
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): Response
    {
        $review = $this->repository->findOneby(['id' => $id]);
        if($review){
            $responseData = $this->serializer->serialize($review, 'json');
            return new JsonResponse($responseData, Response::HTTP_OK);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
