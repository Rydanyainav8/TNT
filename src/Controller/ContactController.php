<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\CommandeType;
use App\Form\CommandType;
use App\Form\UniqueCommandeType;
use Doctrine\ORM\EntityManagerInterface;
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
    public function CommandeAll(Request $req, MailerInterface $mailer): Response
    {
        $materiel = new Materiel();
        // $form = $this->createForm(CommandeType::class, $materiel);
        $form = $this->createForm(CommandType::class, $materiel);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $matSelected = $form['nom']->getData();
            $FromEmail = $form['adresse_email']->getData();
            $numero = $form['numero']->getData();

            $email = (new TemplatedEmail())
                ->from($FromEmail)
                ->to('rydanyaina@gmail.com')
                ->subject('Commande')
                ->htmlTemplate('contact/email.html.twig')
                ->context([
                    'commandes' => $matSelected,
                    'numero' => $numero
                ]);
            $mailer->send($email);
            return $this->redirectToRoute('app_home');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/contact/{id}', name: 'app_contactOne')]
    public function CommandeByOne(Materiel $materiel, Request $req, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $form = $this->createForm(UniqueCommandeType::class, $materiel);
        $form->handleRequest($req);
        $Vimg = $materiel->getImage();
        $matSelected = $materiel->getNom();
        if ($form->isSubmitted() && $form->isValid())
        {
            $FromEmail = $form['adresse_email']->getData();
            $numero = $form['numero']->getData();

            $email = (new TemplatedEmail())
                ->from($FromEmail)
                ->to('rydanyaina@gmail.com')
                ->subject('Commande')
                ->htmlTemplate('contact/unique_email.html.twig')
                ->context([
                    'commandes' => $matSelected,
                    'numero' => $numero
                ]);
            $mailer->send($email);
            return $this->redirectToRoute('app_materiel');
        }

        return $this->render('contact/unique_command.html.twig', [
            'form' => $form->createView(),
            'img' => $Vimg,
            'nomMat' => $matSelected
        ]);
    }
}
