<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;



#[Route('/Dashboard/services', name: 'app_dashboard_services')]
#[IsGranted('ROLE_USER')]

class DashboardServicesController extends AbstractController
{

}