<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciceController extends AbstractController
{
    #[Route('/frontend/exercice', name: 'app_frontend_exercice')]
    public function index(): Response
    {
        return $this->render('frontend/exercice/index.html.twig', [
            'controller_name' => 'ExerciceController',
        ]);
    }
}
