<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\EditMaterielType;
use App\Form\MaterielType;
use App\Repository\MaterielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function indexAdmin(): Response
    {
        return $this->redirectToRoute('index_mat');
    }
    
    #[Route('/admin/MatCreate', name: 'create_mat')]
    public function create(Request $req, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $materiel = new Materiel;
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $image = $form['img']->getData();
            if ($image) 
            {
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originalFileName);
                $newFileName = $safeFileName . '-' . uniqid() . '-' . $image->guessExtension();

                $image->move(
                    $this->getParameter('img_directory'),
                    $newFileName
                );
                $materiel->setImage($newFileName);
            }
            $em->persist($materiel);
            $em->flush();
            return $this->redirectToRoute('index_mat');
        }

        return $this->render('admin/create.html.twig', [
            'form' => $form->createView()
        ]);
    }    

    #[Route('/admin/MatIndex', name: 'index_mat')]
    public function index(MaterielRepository $matRepo): Response
    {
        $materiels = $matRepo->findAll();
        return $this->render('admin/index.html.twig', compact('materiels'));
    }    

    #[Route('/admin/MatEdit/{id}', name: 'edit_mat')]
    public function edit(Materiel $materiel, Request $req, EntityManagerInterface $em, SluggerInterface $slugger ): Response
    {
        $form = $this->createForm(EditMaterielType::class, $materiel);
        $form->handleRequest($req);
        $Vimg = $materiel->getImage();
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $img = $form['img']->getData();
            if ($img) 
            {
                $originalFileName = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originalFileName);
                $newFileName = $safeFileName . '-' . uniqid() . '-' . $img->guessExtension();
                
                $img->move(
                    $this->getParameter('img_directory'),
                    $newFileName
                );
                $materiel->setImage($newFileName);
            }
            $em->persist($materiel);
            $em->flush();
            return $this->redirectToRoute('index_mat');
        }
        return $this->render('admin/edit.html.twig',[
            'form' => $form->createView(),
            'Vimg' => $Vimg
        ]);
    }    

    #[Route('/admin/MatDelete/{id}', name: 'delete_mat')]
    public function delete(EntityManagerInterface $em, Materiel $materiel): Response
    {
        $em->remove($materiel);
        $em->flush();
        $this->addFlash('success', 'article suprimé avec succès');
        return $this->redirectToRoute('index_mat');
    }
}
