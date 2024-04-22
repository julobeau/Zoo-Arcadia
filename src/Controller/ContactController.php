<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\HabitatRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    /**
     * Display contact page and sends Email
     *
     * @param Request $request
     * @param MailerInterface $mailer
     * @param HabitatRepository $HabitatRepository
     * @return Response
     */
    #[Route('/Contact', name:'Contact')]
    public function contact(
        Request $request,
        MailerInterface $mailer,
        HabitatRepository $HabitatRepository
        ): Response
    {
        $habitats = $HabitatRepository->findAll();
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            //dd($data['email']);

            //Email
            $email = (new TemplatedEmail())
                ->from($data['email'])
                ->to('arcadia_contact@arcadia.com')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                ->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject($data['titre'])
                ->text($data['message'])
                ->htmlTemplate('emails/contact.html.twig')

                ->context([
                    'contactName' => $data['nom'],
                    'contactFirstname' => $data['prenom'],
                    'contactEmail' => $data['email'],
                    'subject' => $data['titre'],
                    'message' => $data['message'],
                ]);

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                // some error prevented the email sending; display an
                // error message or try to resend the message
            }

            $this->addFlash(
                'success',
                'Votre message a été envoyé avec succés!Notre équipe vous répondra sous 48h'
            );

            return $this->redirectToRoute('Contact');

            //dd($form->getData());
        }
        
        return $this->render('pages/contact.html.twig', [
            'habitatsList' => $habitats,
            'form' => $form->createView()
        ]);
    }
}
