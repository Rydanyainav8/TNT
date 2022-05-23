<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\CommandeType;
use App\Form\CommandType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $req, MailerInterface $mailer): Response
    {
        $materiel = new Materiel();
        // $form = $this->createForm(CommandeType::class, $materiel);
        $form = $this->createForm(CommandType::class, $materiel);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $matSelected = $form['nom']->getData();
            // $numero = $form['numero']->getData();
            // dd($matSelected);
            // foreach($matSelected as $matSelect)
            // {
            //     echo $matSelect;
            // }
            // $email = (new Email())
            //     ->from('rydan@example.com')
            //     ->to('rydanyaina@gmail.com')
            //     ->subject('test')
            //     // ->text('Sending emails is fun again!');
            //     ->html($matSelect);
            // $mailer->send($email);
            
            $email = (new TemplatedEmail())
                ->from('rydan@example.com')
                ->to('rydanyaina@gmail.com')
                ->subject('Commande')
                ->htmlTemplate('contact/email.html.twig')
                ->context([
                    'commandes' => $matSelected,
                ]);
            $mailer->send($email);
            return $this->redirectToRoute('app_home');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
