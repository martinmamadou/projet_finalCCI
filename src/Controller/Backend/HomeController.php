<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/admin', name: 'admin.index')]
    public function index(): Response
    {

        return $this->render('Backend/Home/index.html.twig', [
            
        ]);
    }
}
