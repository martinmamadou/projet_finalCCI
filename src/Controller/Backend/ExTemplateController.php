<?php

namespace App\Controller\Backend;

use App\Entity\Exercices;
use App\Form\ExMaisonType;
use App\Entity\ExerciceMaison;
use App\Entity\ExTemplate;
use App\Form\ExTemplateType;
use Doctrine\ORM\EntityManager;
use App\Repository\ExercicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ExerciceMaisonRepository;
use App\Repository\ExTemplateRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/exercices', 'admin.exercices')]
class ExTemplateController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ExTemplateRepository $exoRepo

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
        $exercice = new ExTemplate;
        $form = $this->createForm(ExTemplateType::class, $exercice, ['isUser'=>false] );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($exercice);
            $this->em->flush();

            $this->addFlash('success', 'exercice créé avec succès');
            return $this->redirectToRoute('admin.exercices.index');
        }

        return $this->render('Backend/Exercice/create.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?ExTemplate $exercice, Request $request): Response|RedirectResponse
    {
     
        if (!$exercice) {
            $this->addFlash('error', 'exercices inexistant');
            return $this->redirectToRoute('admin.exercices.index');
        }
        $form = $this->createForm(ExTemplateType::class, $exercice);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($exercice);
            $this->em->flush();

            $this->addFlash('success', 'exercice modifié avec succès');
            return $this->redirectToRoute('admin.exercices.index');
        }
        return $this->render('Backend/Exercice/edit.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/{id}/delete', '.delete', methods: ['GET', 'POST'])]
    public function delete(?ExTemplate $exercice, Request $request): Response|RedirectResponse
    {
        if (!$exercice) {

            $this->addFlash('error', 'exercice inexistant');
            return $this->redirectToRoute('admin.exercices.index');
        }
        if ($this->isCsrfTokenValid('delete' . $exercice->getId(), $request->request->get('token'))) {

            //on supprime en bdd
            $this->em->remove($exercice);
            $this->em->flush();

            $this->addFlash('success', 'exercice supprimé avec succes');
            return $this->redirectToRoute('admin.exercices.index');
        }
        return $this->redirectToRoute('admin.exercices.index');
    }
}
