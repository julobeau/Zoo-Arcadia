<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\ServiceImage;
use App\Form\ServiceAddType;
use App\Form\ServiceEditType;
use App\Repository\ServiceRepository;
use App\Repository\ServiceImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\ExpressionLanguage\Expression;

#[Route('/Dashboard/services', name: 'app_dashboard_services_')]
#[IsGranted(
    new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_EMPLOYEE")')
    )]
class DashboardServicesController extends AbstractController
{
    /**
     * Display all services and add one with form
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param ServiceRepository $ServiceRepository
     * @param ServiceImageRepository $ServiceImageRepository
     * @return Response
     */
    #[Route('/', name: 'show', methods: ['GET', 'POST'])]
    public function service(
        Request $request,
        EntityManagerInterface $manager,
        ServiceRepository $ServiceRepository,
        ServiceImageRepository $ServiceImageRepository,
    ): Response
    {

        $existingServices = $ServiceRepository->findAll();

        $service = new Service();
        $form = $this->createForm(ServiceAddType::class, $service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service = $form->getData();
            
            if ($photo = $form['photo']->getData()) {
                $filename = $service->getNom().'-'.bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                $photoDir = $this->getParameter('kernel.project_dir').'/assets/images/services';
                $photo->move($photoDir, $filename);
                $serviceImage = new ServiceImage();
                $serviceImage->setSlug($filename);
                $manager->persist($serviceImage);
                $service->addImage($serviceImage);
                $manager->persist($service);
            }
            $manager->flush();

            $this->addFlash(
                'success',
                'Le nouveau service a été enregistré.'
            );

            return $this->redirectToRoute('app_dashboard_services_show');

        }


        return $this->render('dashboard/dashboardServiceAdd.html.twig', [
            'services' => $existingServices,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * Edit service
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param ServiceRepository $ServiceRepository
     * @param integer $id
     * @return Response
     */
    #[Route('/edit/{id}', name: 'editService', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $manager,
        ServiceRepository $ServiceRepository,
        int $id
    ): Response
    {

        $existingServices = $ServiceRepository->findAll();

        $service = $ServiceRepository->findOneBy(['id' => $id]);

        $form = $this->createForm(ServiceEditType::class, $service);

        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $service = $form->getData();
            $service->setUpdatedAt(new \DateTimeImmutable());

            if ($photo = $form['photo']->getData()) {
                $filename = $service->getNom().'-'.bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                $photoDir = $this->getParameter('kernel.project_dir').'/assets/images/services';
                $photo->move($photoDir, $filename);
                $serviceImage = new ServiceImage();
                $serviceImage->setSlug($filename);
                $service->addImage($serviceImage);
                dd($service);
                $manager->persist($serviceImage);
            }

            $manager->persist($service);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le service a été modifié.'
            );
            return $this->redirectToRoute('app_dashboard_services_show');
        }
        elseif($form->isSubmitted() && !$form->isValid()) {
            echo"probleme";
        }


        return $this->render('dashboard/dashboardServiceEdit.html.twig', [
            'services' => $existingServices,
            'form' => $form->createView(),
            'photo' => $service->getImage()[0]->getSlug()
        ]);
    }
    
    #[Route('/delete/{id}', name: 'deleteServiceConfirm', methods: ['GET'])]
    public function confirmDelete(
        Request $request,
        EntityManagerInterface $manager,
        ServiceRepository $ServiceRepository,
        int $id
    ): Response
    {

        $existingServices = $ServiceRepository->findAll();
        $service = $ServiceRepository->findOneBy(['id' => $id]);


        return $this->render('dashboard/dashboardServicesConfirmDelete.html.twig', [
            'services' => $existingServices,
            'serviceDelete' => $service,
        ]);
    }
    
    #[Route('/delete/delete/{id}', name: 'deleteService', methods: ['GET'])]
    public function delete(
        Request $request,
        EntityManagerInterface $manager,
        ServiceRepository $ServiceRepository,
        int $id
    ): Response
    {
        $service = $ServiceRepository->findOneBy(['id' => $id]);

        $manager->remove($service);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le service a été supprimé.'
        );

        return $this->redirectToRoute('app_dashboard_services_show');

    }
    
}