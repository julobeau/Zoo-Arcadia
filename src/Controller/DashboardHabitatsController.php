<?php

namespace App\Controller;

use App\Entity\Habitat;
use App\Entity\ImagesHabitat;
use App\Form\HabitatAddType;
use App\Form\HabitatImageAddType;
use App\Form\HabitatImageEditType;
use App\Repository\HabitatRepository;
use App\Repository\ImagesHabitatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;




#[Route('/Dashboard/habitat', name: 'app_dashboard_habitats_')]
#[IsGranted('ROLE_USER')]

class DashboardHabitatsController extends AbstractController
{
    #[Route('/', name: 'show', methods: ['GET', 'POST'])]
    public function show(
        Request $request,
        EntityManagerInterface $manager,
        HabitatRepository $HabitatRepository,
    ): Response
    {
        $existinghabitats = $HabitatRepository->findAll();

        $habitat = new Habitat();

        $form = $this->createForm(HabitatAddType::class, $habitat);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $habitat = $form->getData();
            if ($photo = $form['photos']->getData()) {
                $filename = $habitat->getNom().'-'.bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                $photoDir = $this->getParameter('kernel.project_dir').'/assets/images/habitats/'.$habitat->getNom();
                $photo->move($photoDir, $filename);
                $habitatImage = new ImagesHabitat();
                $habitatImage->setImage($filename);
                $habitatImage->setCover(true);
                $manager->persist($habitatImage);
                $habitat->addHabitat($habitatImage);
            }
            $manager->persist($habitat);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le nouveau habitat a été enregistré.'
            );
            return $this->redirectToRoute('app_dashboard_habitats_show');
        }

        elseif($form->isSubmitted() && !$form->isValid()){
            echo"ca foire";
            dd($form['photos']);
            $habitat = $form->getData();
            $string = (string) $form->getErrors(true, false);

            $this->addFlash(
                'error',
                $string
            );
            return $this->redirectToRoute('app_dashboard_habitats_show');
        }

        return $this->render('dashboard/habitats/dashboardHabitatAdd.html.twig', [
            'habitatsList' => $existinghabitats,
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $manager,
        HabitatRepository $HabitatRepository,
        ImagesHabitatRepository $ImagesHabitatRepository,
        int $id
    ): Response
    {
        $existinghabitats = $HabitatRepository->findAll();

        $habitat = $HabitatRepository->findOneBy(['id' => $id]);

        $form = $this->createForm(HabitatAddType::class, $habitat);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $habitat = $form->getData();
            if ($photo = $form['photos']->getData()) {
                $filename = $habitat->getNom().'-'.bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                $photoDir = $this->getParameter('kernel.project_dir').'/assets/images/habitats/'.$habitat->getNom();
                $photo->move($photoDir, $filename);
                $photosHabitat = $ImagesHabitatRepository->findBy(['habitat' => $habitat]);
                foreach($photosHabitat as $photo){
                    $photo->setCover(false);
                }
                $habitatImage = new ImagesHabitat();
                $habitatImage->setImage($filename);
                $habitatImage->setCover(true);
                $manager->persist($habitatImage);
                $habitat->addHabitat($habitatImage);
            }
            $manager->persist($habitat);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'habitat a été modifié.'
            );
            return $this->redirectToRoute('app_dashboard_habitats_show');
        }

        elseif($form->isSubmitted() && !$form->isValid()){
            echo"ca foire";
            dd($form['photos']);
            $habitat = $form->getData();
            $string = (string) $form->getErrors(true, false);

            $this->addFlash(
                'error',
                $string
            );
            return $this->redirectToRoute('app_dashboard_habitats_show');
        }

        if($ImagesHabitatRepository->findBy(['habitat' => $habitat])){
            $photosHabitat = $ImagesHabitatRepository->findBy(['habitat' => $habitat]);
            foreach($photosHabitat as $photo){
                if($photo->isCover()){
                    $photoCover = $photo->getImage();
                }
            }
        }
        else{
            $photo = '';
        }

        return $this->render('dashboard/habitats/dashboardHabitatEdit.html.twig', [
            'habitatSelect' => $habitat,
            'habitatsList' => $existinghabitats,
            'photo' => $photoCover,
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'deleteConfirm', methods: ['GET'])]
    public function confirmDelete(
        HabitatRepository $HabitatRepository,
        int $id
    ): Response
    {

        $habitatsList = $HabitatRepository->findAll();

        $habitat = $HabitatRepository->findOneBy(['id' => $id]);


        return $this->render('dashboard/habitats/dashboardHabitatsConfirmDelete.html.twig', [
            'habitatsList' => $habitatsList,
            'serviceDelete' => $habitat,
        ]);
    }
    
    #[Route('/delete/delete/{id}', name: 'deleteHabitat', methods: ['GET'])]
    public function delete(
        EntityManagerInterface $manager,
        HabitatRepository $habitatRepository,
        int $id
    ): Response
    {
        $habitat = $habitatRepository->findOneBy(['id' => $id]);

        $manager->remove($habitat);
        $manager->flush();

        $this->addFlash(
            'success',
            'L\'habitat a été supprimé.'
        );

        return $this->redirectToRoute('app_dashboard_habitats_show');

    }
    
    #[Route('/images/edit/{id}', name: 'editImageHabitat', methods: ['GET', 'POST'])]
    public function editImage(
        Request $request,
        EntityManagerInterface $manager,
        HabitatRepository $HabitatRepository,
        ImagesHabitatRepository $ImagesHabitatRepository,
        int $id
    ): Response
    {

        $habitatsList = $HabitatRepository->findAll();
        $habitat = $HabitatRepository->findOneBy(['id' => $id]);

        //$habitatImages = $ImagesHabitatRepository->findBy(['habitat' => $habitat]);
        $habitatImages = $ImagesHabitatRepository->findAll();
        //dd($habitatImages);

        $form = $this->createForm(HabitatImageEditType::class, $habitatImages, [
            'habitat' => $habitat->getId(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $habitatImage = $form->getData();
            $habitatImage->setCover(false);
            dd($habitatImage);
        }
        /*$manager->flush();

        $this->addFlash(
            'success',
            'L\'habitat a été supprimé.'
        );*/

        return $this->render('dashboard/habitats/images/dashboardHabitatImageEdit.html.twig', [
            //'habitatSelect' => $habitat,
            'habitatsList' => $habitatsList,
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/images/add', name: 'addImageHabitat', methods: ['GET', 'POST'])]
    public function addImage(
        Request $request,
        EntityManagerInterface $manager,
        HabitatRepository $HabitatRepository,
    ): Response
    {

        $habitatsList = $HabitatRepository->findAll();
        //$habitat = $HabitatRepository->findOneBy(['id' => $id]);

        $habitatImage = new ImagesHabitat();

        $form = $this->createForm(HabitatImageAddType::class, $habitatImage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $habitatImage = $form->getData();
            $habitatImage->setCover(false);
            dd($habitatImage);
        }
        /*$manager->flush();

        $this->addFlash(
            'success',
            'L\'habitat a été supprimé.'
        );*/

        return $this->render('dashboard/habitats/images/dashboardHabitatImageAdd.html.twig', [
            //'habitatSelect' => $habitat,
            'habitatsList' => $habitatsList,
            'form' => $form->createView()
        ]);
    }
}