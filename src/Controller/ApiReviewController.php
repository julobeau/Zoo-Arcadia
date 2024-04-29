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
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

#[Route('/api/review', name:'app_api_review_')]
class ApiReviewController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private ReviewRepository $repository,
        private SerializerInterface $serializer,
        private HtmlSanitizerInterface $htmlSanitizer,
        )
    {
    }
    #[Route(name: 'new', methods:['POST'] )]
    public function addReview(
        Request $request,
        HtmlSanitizerInterface $htmlSanitizer,
        ): Response
    {
        $reviewPosted = $request->toArray();
        $reviewNote = (int)$reviewPosted['Note'];
        $review = new Review();
        $review->setPseudo($htmlSanitizer->sanitize($reviewPosted['Pseudo']))
                ->setNote($reviewNote)
                ->setComment($htmlSanitizer->sanitize($reviewPosted['Comment']))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setValidated(false);

        $this->manager->persist($review);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($review, 'json');

        return $this->json($responseData,
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
