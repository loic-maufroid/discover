<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Model\Contact;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="form_contact")
     */
    public function index(Request $request,\Swift_Mailer $mailer)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class,$contact);
            

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                
                dump($form->getData());

                $this->addFlash('success','Message bien envoyé !');

                $message = (new \Swift_Message('Email test'))
                ->setFrom("supermail@hotmail.fr")
                ->setTo($contact->getEmail())
                ->setBody('<p>'.$contact->getMessage().'</p>');

                $mailer->send($message);

                $contact = new Contact();
                $form = $this->createForm(ContactType::class,$contact);
            }


        return $this->render('contact/index.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
