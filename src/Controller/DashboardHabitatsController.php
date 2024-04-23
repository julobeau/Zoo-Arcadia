<?php

namespace App\Controller;

use App\Entity\Habitat;
use App\Entity\ImagesHabitat;
use App\Form\HabitatAddType;
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

    /**
     * Create habitat
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param HabitatRepository $HabitatRepository
     * @return Response
     */
    #[Route('/', name: 'show', methods: ['GET', 'POST'])]
    public function show(
        Request $request,
        EntityManagerInterface $manager,
        HabitatRepository $HabitatRepository,
    ): Response
    {

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
            'habitatsList' => $this->existinghabitats,
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit habitat
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param HabitatRepository $HabitatRepository
     * @param ImagesHabitatRepository $ImagesHabitatRepository
     * @param integer $id
     * @return Response
     */
    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $manager,
        HabitatRepository $HabitatRepository,
        ImagesHabitatRepository $ImagesHabitatRepository,
        int $id
    ): Response
    {
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
            'habitatsList' => $this->existinghabitats,
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

        $habitat = $HabitatRepository->findOneBy(['id' => $id]);


        return $this->render('dashboard/habitats/dashboardHabitatsConfirmDelete.html.twig', [
            'habitatsList' => $this->existinghabitats,
            'serviceDelete' => $habitat,
        ]);
    }
    
    /**
     * Delete habitat
     *
     * @param EntityManagerInterface $manager
     * @param HabitatRepository $habitatRepository
     * @param integer $id
     * @return Response
     */
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
    
    /**
     * Add/delete images of habitat
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param HabitatRepository $HabitatRepository
     * @param ImagesHabitatRepository $ImagesHabitatRepository
     * @param integer $id
     * @return Response
     */
    #[Route('/images/edit/{id}', name: 'editImageHabitat', methods: ['GET', 'POST'])]
    public function editImage(
        Request $request,
        EntityManagerInterface $manager,
        HabitatRepository $HabitatRepository,
        ImagesHabitatRepository $ImagesHabitatRepository,
        int $id
    ): Response
    {
        $habitat = $HabitatRepository->findOneBy(['id' => $id]);

        $habitatImages = $ImagesHabitatRepository->findAll();

        $form = $this->createForm(HabitatImageEditType::class, $habitatImages, [
            'habitat' => $habitat->getId(),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() && 'add' === $form->getClickedButton()->getName()) {
                if ($photo = $form['newImage']->getData()) {
                    $filename = $habitat->getNom().'-'.bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                    $photoDir = $this->getParameter('kernel.project_dir').'/assets/images/habitats/'.$habitat->getNom();
                    $photo->move($photoDir, $filename);
                    $imageHabitat = new ImagesHabitat();
                    $imageHabitat->setImage($filename);
                    $imageHabitat->setCover(false);
                    $imageHabitat->setHabitat($habitat);
                    $manager->persist($imageHabitat);
                    $manager->flush();
                    $this->addFlash(
                        'success',
                        'Image ajoutée avec succès'
                    );
                    return $this->redirectToRoute('app_dashboard_habitats_editImageHabitat', ['id' => $habitat->getId()]);
                }
            }
            elseif($form->getClickedButton() && 'supprimer' === $form->getClickedButton()->getName()) {
                $imagesToDelete = $form['image']->getData();
                foreach($imagesToDelete as $imageDelete){
                    $manager->remove($imageDelete);
                    $manager->flush();
                }
                $this->addFlash(
                    'success',
                    'Image(s) supprimée(s) avec succès'
                );

                return $this->redirectToRoute('app_dashboard_habitats_editImageHabitat', ['id' => $habitat->getId()]);
            }
        }
        elseif($form->isSubmitted() && !$form->isValid()){
            $string = (string) $form->getErrors(true, false);

            $this->addFlash(
                'error',
                $string
            );
            return $this->redirectToRoute('app_dashboard_habitats_editImageHabitat', ['id' => $habitat->getId()]);
        }

        return $this->render('dashboard/habitats/images/dashboardHabitatImageEdit.html.twig', [
            //'habitatSelect' => $habitat,
            'habitatsList' => $this->existinghabitats,
            'habitat' => $habitat->getNom(),
            'form' => $form->createView()
        ]);
    }
}