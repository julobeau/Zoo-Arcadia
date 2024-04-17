<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/Dashboard', name: 'app_dashboard')]
class DashboardController extends AbstractController
{
    #[Route('/', name: '_general')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        return $this->render('dashboard/dashboard.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    #[Route('/User', name: '_users', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function user(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $manager,
        MailerInterface $mailer
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $hashPasssword = $hasher->hashPassword(
                $user,
                $user->getPassword()
            );

            $user->setPassword($hashPasssword);
            
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le nouvel utilisateur a été enregistré. Il en sera notifié par email. Pensez à lui donner son mot de passe en main propre'
            );

            return $this->redirectToRoute('app_dashboard_users');

        }

        return $this->render('dashboard/dashboardUser.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
