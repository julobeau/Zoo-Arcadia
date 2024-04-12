<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Habitats')]

class HabitatsController extends AbstractController
{
    public $lesHabitats = ['Savane', 'Jungle', 'Marais'];

    #[Route('/')]
    public function habitats(): Response
    {
        return $this->render('pages/habitats.html.twig',
            
        );
    }

    #[Route('/Savane')]
    public function savane(): Response
    {
        return $this->render('pages/savane.html.twig',
        ['titreHabitat' => 'Savane']
        );
    }
    
    #[Route('/Jungle')]
    public function jungle(): Response
    {
        return $this->render('pages/jungle.html.twig',
        ['titreHabitat' => 'Jungle']
        );
    }
    
    #[Route('/Marais')]
    public function marais(): Response
    {
        return $this->render('pages/marais.html.twig',
        ['titreHabitat' => 'Marais']
        );
    }
}