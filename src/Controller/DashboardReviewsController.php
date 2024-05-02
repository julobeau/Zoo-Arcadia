<?php

namespace App\Controller;

use App\Repository\HabitatRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ReviewValidationType;


#[Route('/Dashboard/review', name: 'app_dashboard_reviews_')]
#[IsGranted('ROLE_EMPLOYEE')]
class DashboardReviewsController extends AbstractController
{
    private $existinghabitats;

    /**
     * Get habitats list
     *
     * @param HabitatRepository $HabitatRepository
     */
    public function __construct(
        HabitatRepository $HabitatRepository,
    )
    {
        $this->existinghabitats = $HabitatRepository->findAll();
    }

    #[Route('/validate', name: 'validate', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_EMPLOYEE')]
    public function show(
        Request $request,
        ReviewRepository $ReviewRepository,
        EntityManagerInterface $manager,

    ): Response
    {
        $reviewNotValidated = $ReviewRepository->findBy(['is_validated' => false]);
        if(!empty($reviewNotValidated)){
            $form = $this->createForm(ReviewValidationType::class, $reviewNotValidated[0]);
            $message = count($reviewNotValidated);
        }
        else{
            return $this->redirectToRoute('app_dashboard');
        }
        if($form){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if ($form->getClickedButton() && 'Validate' === $form->getClickedButton()->getName()) {
                    $reviewId = $form->getData()->getId();
                    $review = $ReviewRepository->findOneBy(['id' => $reviewId]);
                    $review->setValidated(true);
                    $manager->persist($review);
                    $manager->flush();
                }
                elseif($form->getClickedButton() && 'Reject' === $form->getClickedButton()->getName()){
                    $reviewId = $form->getData()->getId();
                    $review = $ReviewRepository->findOneBy(['id' => $reviewId]);
                    $manager->remove($review);
                    $manager->flush();
                }
            return $this->redirectToRoute('app_dashboard_reviews_validate');
            }
        }


        return $this->render('dashboard/reviews/dashboardReviews.html.twig', [
            'review' => $reviewNotValidated[0],
            'reviewsToValidateCount' => $message,
            'habitatsList' => $this->existinghabitats,
            'form' => $form->createView()
        ]);
    }
}