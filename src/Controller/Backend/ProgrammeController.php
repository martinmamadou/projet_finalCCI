<?php

namespace App\Controller\Backend;

use App\Entity\ProgrammeMaison;
use App\Form\ProMaisonType;
use App\Repository\ProgrammeMaisonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


#[Route('admin/promaison','admin.promaison')]
class ProgrammeController extends AbstractController
{

public function __construct(
    private readonly EntityManagerInterface $em,
    private readonly ProgrammeMaisonRepository $ProMaisonRepository
    )
{
    

}
    #[Route('', name: '.index', methods:['GET'])]
    public function index(): Response|RedirectResponse
    {
        return $this->render('Backend/Programme/index.html.twig', [
            'programmes' => $this->ProMaisonRepository->findAll()
        ]);
    }

    #[Route('/create', name: '.create', methods:['GET','POST'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $programme = new ProgrammeMaison;
        $form = $this->createForm(ProMaisonType::class, $programme);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($programme);
            $this->em->flush();
        }
        return $this->render('Backend/Programme/create.html.twig', [
            'form' => $form
        ]);
    }
}

