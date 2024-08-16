<?php

namespace App\Controller\Frontend;

use App\Repository\ProgrammeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/programmes','programmes')]
class TrainingController extends AbstractController
{
    public function __construct(
        private readonly ProgrammeRepository $proRepo,
        private readonly UserRepository $userRepo,
    )
    {

    }
    #[Route('/{slug}/training', name: '.training', methods: ['GET'])]
    public function index(string $slug): Response
    {
        $programme = $this->proRepo->findOneBy(['slug'=>$slug]);
        
        return $this->render('frontend/training/index.html.twig', [
            'programme' => $programme
        ]);
    }
    #[Route('/{slug}/preview', name: '.preview', methods: ['GET'])]
    public function preview(string $slug): Response
    {
        $programme = $this->proRepo->findOneBy(['slug'=>$slug]);
        
        return $this->render('frontend/training/preview.html.twig', [
            'programme' => $programme
        ]);
    }
}
