<?php

namespace App\Controller\Backend;

use App\Entity\Membre;
use App\Form\MembreType;
use App\Repository\MembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/membre','admin.membre')]
class MembreController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em
    )
    {
        
    }
    #[Route('/', name: '.index', methods: ['GET'])]
    public function index(MembreRepository $membreRepository): Response
    {
        return $this->render('Backend/Membre/index.html.twig', [
            'membres' => $membreRepository->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $membre = new Membre();
        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($membre);
            $entityManager->flush();

            return $this->redirectToRoute('admin.membre.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Backend/Membre/new.html.twig', [
            'membre' => $membre,
            'form' => $form,
        ]);
    }


    #[Route('membre/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Membre $membre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.membre.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Backend/Membre/edit.html.twig', [
            'membre' => $membre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', '.delete', methods: ['GET', 'POST'])]
    public function delete(?Membre $membre, Request $request): Response|RedirectResponse
    {
        if (!$membre) {

            $this->addFlash('error', 'programme inexistant');
            return $this->redirectToRoute('admin.users.index');
        }
        if ($this->isCsrfTokenValid('delete' . $membre->getId(), $request->request->get('token'))) {

            //on supprime en bdd
            $this->em->remove($membre);
            $this->em->flush();

            $this->addFlash('success', 'membre supprimer  avec succes');
            return $this->redirectToRoute('admin.membre.index');
        }
        return $this->redirectToRoute('admin.programmes.index');
    }
}
