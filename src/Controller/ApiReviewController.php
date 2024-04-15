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
        $reviewPosted = $request->toArray();
        $reviewNote = (int)$reviewPosted['Note'];
        $review = new Review();
        $review->setPseudo($reviewPosted['Pseudo']);
        $review->setNote($reviewNote);
        $review->setComment($reviewPosted['Comment']);
        $review->setCreatedAt(new \DateTimeImmutable());
        $review->setValidated(false);

        /*$this->manager->persist($review);
        $this->manager->flush();*/

        $responseData = $this->serializer->serialize($review, 'json');

        return $this->json($responseData,
            /*[
                'Pseudo' => $review->getPseudo(),
                'Note' => $review->getNote(),
                'Comment' => $review->getComment()
            ],*/
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
    
    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): Response
    {
        $review = $this->repository->findOneby(['id' => $id]);
        if($review){
            $responseData = $this->serializer->serialize($review, 'json');
            return new JsonResponse($responseData, Response::HTTP_OK);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
