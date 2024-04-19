<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationType;
use App\Repository\UserRepository;
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


#[Route('/Dashboard/User', name: 'app_dashboard_users')]
class DashboardUserController extends AbstractController
{
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

    #[Route('/', name: '_add', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function user(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $manager,
        MailerInterface $mailer,
        UserRepository $userRepository
    ): Response {
        $existingUsers = $userRepository->findAll();

        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

            return $this->redirectToRoute('app_dashboard_users_add');
        }

        return $this->render('dashboard/dashboardUserAdd.html.twig', [
            'users' => $existingUsers,
            'form' => $form->createView()
        ]);
    }

    #[Route('/Edit/{id}', name: '_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $manager,
        MailerInterface $mailer,
        UserRepository $userRepository,
        int $id
    ): Response {
        $existingUsers = $userRepository->findAll();

        $user = $userRepository->findOneby(['id' => $id]);

        $form = $this->createForm(UserRegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $hashPasssword = $hasher->hashPassword(
                $user,
                $user->getPassword()
            );

            $user->setPassword($hashPasssword);
            //dd($user);
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
                ->subject('Modification utilisateur - Zoo Arcadia')
                ->text('Vous avez été enregistré comme nouvel utilisateur du site du Zoo Arcadia')
                ->htmlTemplate('emails/newUser.html.twig')

                ->context([
                    'contactName' => $user->getName(),
                    'contactFirstname' => $user->getFirstname(),
                    'contactEmail' => $user->getEmail(),
                    'subject' => 'Modification utilisateur - Zoo Arcadia',
                ]);

            try {
                $mailer->send($email);
                $this->addFlash(
                    'success',
                    'L\'utilisateur a été modifié. Il en sera notifié par email.
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
            return $this->redirectToRoute('app_dashboard_users_add');
        }

        return $this->render('dashboard/dashboardEditUser.html.twig', [
            'users' => $existingUsers,
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: '_delete', methods: 'GET')]
    public function delete(
        EntityManagerInterface $manager,
        UserRepository $userRepository,
        int $id
    ): Response {
        $user = $userRepository->findOneby(['id' => $id]);
        $existingUsers = $userRepository->findAll();

        return $this->render('dashboard/dashboardDeleteUser.html.twig', [
            'users' => $existingUsers,
            'deleteUser' => $user
        ]);
    }

    #[Route('/delete/delete/{id}', name: '_deleteUser_delete', methods: 'GET')]
    public function deleteBdd(
        EntityManagerInterface $manager,
        UserRepository $userRepository,
        int $id
    ): Response {
        $user = $userRepository->findOneby(['id' => $id]);

        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'L\'utilisateur a été supprimé.'
        );

        return $this->redirectToRoute('app_dashboard_users_add');
    }
}
