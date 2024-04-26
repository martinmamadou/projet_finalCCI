<?php

namespace App\Controller\Frontend;

use App\Repository\CategorieRepository;
use App\Repository\ProgrammeMaisonRepository;
use App\Repository\ProgrammeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/programmes', 'user.programmes')]
class ProgrammeController extends AbstractController
{
    public function __construct(
        private readonly ProgrammeRepository $proRepo,
        private readonly CategorieRepository $categRepository,
    ) {
    }

    #[Route('', name: '.index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('Frontend/Programme/index.html.twig', [
            'programmes' => $this->proRepo->findAll(),
            'categories' => $this->categRepository->findAll()
        ]);
    }

    #[Route('/{slug}/list', name: '.list', methods: ['GET', 'POST'])]
    public function list(string $slug): Response
    {
        $categorie = $this->categRepository->findOneBy(['slug' => $slug]);
        $programmes = [];

        if ($categorie) {
            $programmes = $categorie->getProgramme();
        }
        return $this->render('Frontend/Programme/list.html.twig', [
            'programmes' => $programmes,
            'categories' => $categorie
        ]);
    }
}
