<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;


#[Route('/Dashboard', name: 'app_dashboard')]
class DashboardController extends AbstractController
{
    /**
     * Display all users
     *
     * @return Response
     */
    #[Route('/', name: '_general')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        return $this->render('dashboard/dashboard.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    /**
     * Add a new user with form and send mail
     *
     * @param Request $request
     * @param UserPasswordHasherInterface $hasher
     * @param EntityManagerInterface $manager
     * @param MailerInterface $mailer
     * @param UserRepository $userRepository
     * @return Response
     */
    
    #[Route('/User', name: '_users', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function user(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $manager,
        MailerInterface $mailer,
        UserRepository $userRepository
    ): Response
    {
        $existingUsers = $userRepository->findAll();

        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);

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

            /**
             * Envoie du mail de confirmation
             */

            $email = (new TemplatedEmail())
                ->from('arcadia_contact@arcadia.com')
                ->to($user->getEmail())
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                ->replyTo('arcadia_contact@arcadia.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Nouvel utilisateur - Zoo Arcadia')
                ->text('Vous avez été enregistré comme nouvel utilisateur du site du Zoo Arcadia')
                ->htmlTemplate('emails/newUser.html.twig')

                ->context([
                    'contactName' => $user->getName(),
                    'contactFirstname' => $user->getFirstname(),
                    'contactEmail' => $user->getEmail(),
                    'subject' => 'Nouvel utilisateur - Zoo Arcadia',
                ]);

            try {
                $mailer->send($email);
                $this->addFlash(
                    'success',
                    'Le nouvel utilisateur a été enregistré. Il en sera notifié par email.
                    Pensez à lui donner son mot de passe en main propre'
                );
            } catch (TransportExceptionInterface $e) {
                // some error prevented the email sending; display an
                // error message or try to resend the message
                $this->addFlash(
                    'error',
                    'Quelque chose s\'est mal passé'
                );

            }

            return $this->redirectToRoute('app_dashboard_users');
        }

        return $this->render('dashboard/dashboardUser.html.twig', [
            'users' => $existingUsers,
            'form' => $form->createView()
        ]);
    }

    #[Route('/User/Edit/{id}', name: '_editUser', methods: ['GET', 'POST'])]
    public function edit(
        EntityManagerInterface $manager,
        UserRepository $userRepository,
        int $id
        ): Response
    {
        $existingUsers = $userRepository->findAll();

        $user = $userRepository->findOneby(['id' => $id]);

        $form = $this->createForm(UserRegistrationType::class, $user);

        //$form->handleRequest($request);

        return $this->render('dashboard/dashboardEditUser.html.twig', [
            'users' => $existingUsers,
            'form' => $form->createView()
        ]);

    }

    #[Route('/User/delete/{id}', name: '_deleteUser', methods: 'GET')]
    public function delete(EntityManagerInterface $manager, UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->findOneby(['id' => $id]);
        if($user){
            dd($user);
            /*$manager->remove($user);
            $manager->flush;*/
            return $this->redirectToRoute('app_dashboard_users');

            }
    }
}
