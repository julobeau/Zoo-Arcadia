<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/Contact', name:'Contact')]
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $this->addFlash(
                'success',
                'Votre message a été envoyé avec succés!'
            );

            return $this->redirectToRoute('Contact');

            //dd($form->getData());
        }
        
        return $this->render('pages/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
