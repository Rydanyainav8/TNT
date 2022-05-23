<?php

namespace App\Controller;

use App\Repository\MaterielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaterielController extends AbstractController
{
    #[Route('/materiel', name: 'app_materiel')]
    public function index(MaterielRepository $mateRepo): Response
    {
        $materials = $mateRepo->findAll();
        return $this->render('materiel/index.html.twig', [
            'materiels' => $materials,
        ]);
    }
}
