<?php

namespace App\Controller\Frontend;

use App\Repository\ProgrammeMaisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/programmes', 'user.programmes')]
class ProgrammeController extends AbstractController
{
    public function __construct(
        private readonly ProgrammeMaisonRepository $proMaisonRepo
    ) {
    }

    #[Route('', name: '.index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('Frontend/Programme/index.html.twig', [
            'programmes' => $this->proMaisonRepo->findAll()
        ]);
    }
}
