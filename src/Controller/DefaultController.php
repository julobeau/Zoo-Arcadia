<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/')]
    public function home(): Response
    {
        return $this->render('pages/home.html.twig');
    }
    
    #[Route('/Services')]
    public function service(ServiceRepository $ServiceRepository): Response
    {
        $allServices = $ServiceRepository->findAll();
        //$imageService = $allServices->getImage();
        //dd($allServices[2]->getImage()[0]);
        return $this->render('pages/services.html.twig',
        ['allService' => $allServices]
    );
    }
    
    #[Route('/Contact')]
    public function contact(): Response
    {
        return $this->render('pages/contact.html.twig',);
    }
    
    #[Route('/Connexion')]
    public function connexion(): Response
    {
        return $this->render('pages/connexion.html.twig',);
    }

}