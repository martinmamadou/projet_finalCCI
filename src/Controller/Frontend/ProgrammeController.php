<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProgrammeController extends AbstractController
{
    #[Route('/frontend/programme', name: 'app_frontend_programme')]
    public function index(): Response
    {
        return $this->render('frontend/programme/index.html.twig', [
            'controller_name' => 'ProgrammeController',
        ]);
    }
}
