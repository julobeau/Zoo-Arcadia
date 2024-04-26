<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\ImagesAnimaux;
use App\Entity\RapportVeterinaireAnimal;
use App\Form\AnimalAddType;
use App\Form\AnimalImageEditType;
use App\Repository\AnimalRepository;
use App\Repository\HabitatRepository;
use App\Repository\ImagesAnimauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;


#[Route('/Dashboard/animals', name: 'app_dashboard_animals_')]
#[IsGranted('ROLE_USER')]
class DashboardAnimalsController extends AbstractController
{
    private $existinghabitats;
    private $animalsList;

    /**
     * Get habitats list
     *
     * @param HabitatRepository $HabitatRepository
     */
    public function __construct(
        HabitatRepository $HabitatRepository,
        AnimalRepository $AnimalRepository,
        private Security $security,
    )
    {
        $this->existinghabitats = $HabitatRepository->findAll();
        $this->animalsList = $AnimalRepository->findAll();

    }

    #[Route('/', name: 'show')]

    #[IsGranted('ROLE_USER')]
    public function index(
    ): Response
    {
        if($this->security->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_dashboard_animals_add');
        }

        return $this->render('dashboard/animals/dashboardAnimals.html.twig', [
            'habitatsList' => $this->existinghabitats,
            'animals' => $this->animalsList,
        ]);
    }
    
    /**
     * Add a new animal
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param AnimalRepository $AnimalRepository
     * @return Response
     */
    #[Route('/add', name: 'add', methods:['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function add(
        Request $request,
        EntityManagerInterface $manager,
        AnimalRepository $AnimalRepository,
        ImagesAnimauxRepository $ImagesAnimauxRepository,

    ): Response
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalAddType::class, $animal);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $animal = $form->getData();
            $manager->persist($animal);
            $manager->flush();
            if ($photo = $form['photos']->getData()) {
                $filename = $animal->getId().'-'.bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                $photoDir = $this->getParameter('kernel.project_dir').'/assets/images/animaux/'.$animal->getId();
                $photo->move($photoDir, $filename);
                $photosAnimal = $ImagesAnimauxRepository->findBy(['animal' => $animal]);
                foreach($photosAnimal as $photo){
                    $photo->setCover(false);
                }
                $animalImage = new ImagesAnimaux();
                $animalImage->setImage($filename);
                $animalImage->setCover(true);
                $manager->persist($animalImage);
                $animal->addImage($animalImage);
                //dd($animal);
            }
            $rapportInitial = new RapportVeterinaireAnimal;
            $rapportInitial->setEtat("Rapport initial");
            $rapportInitial->setNourriture("");
            $rapportInitial->setQuantiteNourriture(0);

            $manager->persist($rapportInitial);

            $animal->addRapportVeterinaireAnimal($rapportInitial);

            $manager->persist($animal);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le nouvel animal a été enregistrée.'
            );
            return $this->redirectToRoute('app_dashboard_animals_show');
        }

        return $this->render('dashboard/animals/dashboardAnimalAdd.html.twig', [
            'habitatsList' => $this->existinghabitats,
            'animals' => $this->animalsList,
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit an animal
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param AnimalRepository $AnimalRepository
     * @param ImagesAnimauxRepository $ImagesAnimauxRepository
     * @param integer $id
     * @return Response
     */
    #[Route('/edit/{id}', name: 'edit', methods:['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(
        Request $request,
        EntityManagerInterface $manager,
        AnimalRepository $AnimalRepository,
        ImagesAnimauxRepository $ImagesAnimauxRepository,
        int $id,
    ): Response
    {
        $animal = $AnimalRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(AnimalAddType::class, $animal);

        $photoCover = '';
        $photos = $animal->getImages();
        foreach($photos as $photo){
            if($photo->isCover()){
                $photoCover = $photo->getImage();
            }
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $animal = $form->getData();
            if ($photo = $form['photos']->getData()) {
                $filename = $animal->getId().'-'.bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                $photoDir = $this->getParameter('kernel.project_dir').'/assets/images/animaux/'.$animal->getId();
                $photo->move($photoDir, $filename);
                $photosAnimal = $ImagesAnimauxRepository->findBy(['animal' => $animal]);
                if(!empty($photosAnimal)){
                    foreach($photosAnimal as $photo){
                        $photo->setCover(false);
                    }
                }
                $animalImage = new ImagesAnimaux();
                $animalImage->setImage($filename);
                $animalImage->setCover(true);
                $manager->persist($animalImage);
                $animal->addImage($animalImage);
            }
            //dd($animal);
            $manager->persist($animal);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'animal a été modifié.'
            );
            return $this->redirectToRoute('app_dashboard_animals_show');
        }
        elseif($form->isSubmitted() && !$form->isValid()){
            //$animal = $form->getData();
            $string = (string) $form->getErrors(true, false);

            $this->addFlash(
                'error',
                $string
            );
            return $this->redirectToRoute('app_dashboard_habitats_show');
        }


        return $this->render('dashboard/animals/dashboardAnimalEdit.html.twig', [
            'habitatsList' => $this->existinghabitats,
            'animals' => $this->animalsList,
            'animal' => $animal,
            'photo' => $photoCover,
            'form' => $form->createView()

        ]);
    }
    
    /**
     * Display animal delete confirmation
     *
     * @param AnimalRepository $AnimalRepository
     * @param integer $id
     * @return Response
     */
    #[Route('/delete/{id}', name: 'deleteConfirm', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function confirmDelete(
        AnimalRepository $AnimalRepository,
        int $id
    ): Response
    {

        $animal = $AnimalRepository->findOneBy(['id' => $id]);


        return $this->render('dashboard/animals/dashboardAnimalsConfirmDelete.html.twig', [
            'habitatsList' => $this->existinghabitats,
            'animals' => $this->animalsList,
            'animalDelete' => $animal,
        ]);
    }
    
    /**
     * delete animal from bdd
     *
     * @param EntityManagerInterface $manager
     * @param AnimalRepository $AnimalRepository
     * @param integer $id
     * @return Response
     */
    #[Route('/delete/delete/{id}', name: 'deleteAnimal', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(
        EntityManagerInterface $manager,
        AnimalRepository $AnimalRepository,
        int $id
    ): Response
    {
        $animal = $AnimalRepository->findOneBy(['id' => $id]);

        $manager->remove($animal);
        $manager->flush();

        $this->addFlash(
            'success',
            'L\'animal a été supprimé.'
        );

        return $this->redirectToRoute('app_dashboard_animals_show');

    }

    /**
     * Add/delete aniaml images
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param AnimalRepository $AnimalRepository
     * @param ImagesAnimauxRepository $ImagesAnimauxRepository
     * @param integer $id
     * @return Response
     */
    #[Route('/images/edit/{id}', name: 'editImageAnimal', methods: ['GET', 'POST'])]
    public function editImage(
        Request $request,
        EntityManagerInterface $manager,
        AnimalRepository $AnimalRepository,
        ImagesAnimauxRepository $ImagesAnimauxRepository,
        int $id
    ): Response
    {
        $animal = $AnimalRepository->findOneBy(['id' => $id]);

        $animalImages = $ImagesAnimauxRepository->findAll();

        $form = $this->createForm(AnimalImageEditType::class, $animalImages, [
            'animal' => $animal->getId(),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() && 'add' === $form->getClickedButton()->getName()) {
                if ($photo = $form['newImage']->getData()) {
                    $filename = $animal->getId().'-'.bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                    $photoDir = $this->getParameter('kernel.project_dir').'/assets/images/animaux/'.$animal->getId();
                    $photo->move($photoDir, $filename);
                    $imageAnimal = new ImagesAnimaux();
                    $imageAnimal->setImage($filename);
                    $imageAnimal->setCover(false);
                    $imageAnimal->setAnimal($animal);
                    $manager->persist($imageAnimal);
                    $manager->flush();
                    $this->addFlash(
                        'success',
                        'Image ajoutée avec succès'
                    );
                    return $this->redirectToRoute('app_dashboard_animals_editImageAnimal', ['id' => $animal->getId()]);
                }
            }
            elseif($form->getClickedButton() && 'supprimer' === $form->getClickedButton()->getName()) {
                $filesystem = new Filesystem();
                $imagesToDelete = $form['image']->getData();
                foreach($imagesToDelete as $imageDelete){
                    $filename = $imageDelete->getImage();
                    $pathFile = $this->getParameter('kernel.project_dir').'/assets/images/animaux/'.$animal->getId().'/'.$filename;
                    $manager->remove($imageDelete);
                    $manager->flush();
                    try{
                        $filesystem->remove([$pathFile, 'activity.log']);
                    } catch(IOExceptionInterface $exception){
                        echo "An error occurred while deleting the file at ".$exception->getPath();
                    }
                }
                $this->addFlash(
                    'success',
                    'Image(s) supprimée(s) avec succès'
                );

                return $this->redirectToRoute('app_dashboard_animals_editImageAnimal', ['id' => $animal->getId()]);
            }
        }
        elseif($form->isSubmitted() && !$form->isValid()){
            $string = (string) $form->getErrors(true, false);

            $this->addFlash(
                'error',
                $string
            );
            return $this->redirectToRoute('app_dashboard_animals_editImageAnimal', ['id' => $animal->getId()]);
        }

        return $this->render('dashboard/animals/dashboardAnimalImageEdit.html.twig', [
            //'habitatSelect' => $habitat,
            'habitatsList' => $this->existinghabitats,
            'animals' => $this->animalsList,
            'animal' => $animal,
            'form' => $form->createView()
        ]);
    }
}
