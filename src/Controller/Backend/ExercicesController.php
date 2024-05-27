<?php

namespace App\Controller\Backend;

use App\Entity\Exercices;
use App\Form\ExMaisonType;
use App\Entity\ExerciceMaison;
use Doctrine\ORM\EntityManager;
use App\Repository\ExercicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ExerciceMaisonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/exercices', 'admin.exercices')]
class ExercicesController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ExercicesRepository $exoRepo

    ) {
    }

    #[Route('/index', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Exercice/index.html.twig', [

            "exercices" => $this->exoRepo->findAll()

        ]);
    }


    #[Route('/create', '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $exercice = new Exercices;
        $form = $this->createForm(ExMaisonType::class, $exercice, ['isUser'=>false] );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($exercice);
            $this->em->flush();
        }

        return $this->render('Backend/Exercice/create.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Exercices $exercice, Request $request): Response|RedirectResponse
    {
        if (!$exercice) {
            $this->addFlash('error', 'exercices inexistant');
            return $this->redirectToRoute('admin.exercices.index');
        }
        $form = $this->createForm(ExMaisonType::class, $exercice);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($exercice);
            $this->em->flush();

            $this->addFlash('success', 'Utilisateur modifier avec succès');
            return $this->redirectToRoute('admin.exercices.index');
        }
        return $this->render('Backend/Exercice/edit.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/{id}/delete', '.delete', methods: ['GET', 'POST'])]
    public function delete(?Exercices $exercice, Request $request): Response|RedirectResponse
    {
        if (!$exercice) {

            $this->addFlash('error', 'exercice inexistant');
            return $this->redirectToRoute('admin.exercices.index');
        }
        if ($this->isCsrfTokenValid('delete' . $exercice->getId(), $request->request->get('token'))) {

            //on supprime en bdd
            $this->em->remove($exercice);
            $this->em->flush();

            $this->addFlash('success', 'exercice supprimer  avec succes');
            return $this->redirectToRoute('admin.exercices.index');
        }
        return $this->redirectToRoute('admin.exercices.index');
    }
}
