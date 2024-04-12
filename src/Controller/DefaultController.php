<?php

namespace App\Controller;

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
    public function service(): Response
    {
        return $this->render('pages/services.html.twig');
    }

}