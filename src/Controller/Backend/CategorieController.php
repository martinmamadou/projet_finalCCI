<?php

namespace App\Controller\Backend;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/categories', 'admin.categories')]
class CategorieController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly CategorieRepository $CategRepository
    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {

        return $this->render('Backend/Categorie/index.html.twig', [
            'categories' => $this->CategRepository->findAll()
        ]);
    }

    #[Route('/create', '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $categorie = new Categorie;
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie
                ->setEnable(1);
            $this->em->persist($categorie);
            $this->em->flush();

            $this->addFlash('success', 'Categorie creer avec succès');
            return $this->redirectToRoute('admin.categories.index');
        }

        return $this->render('Backend/Categorie/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Categorie $categorie, Request $request): Response|RedirectResponse
    {
        if (!$categorie) {
            $this->addFlash('error', 'categorie inexistante');
            return $this->redirectToRoute('admin.categories.index');
        }
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($categorie);
            $this->em->flush();

            $this->addFlash('success', 'Categorie modifier avec succès');
            return $this->redirectToRoute('admin.categories.index');
        }
        return $this->render('Backend/Categorie/edit.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/{id}/delete', '.delete', methods: ['GET', 'POST'])]
    public function delete(?Categorie $categorie, Request $request): Response|RedirectResponse
    {
        if (!$categorie) {

            $this->addFlash('error', 'Categorie inexistante');
            return $this->redirectToRoute('admin.categories.index');
        }
        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->request->get('token'))) {

            //on supprime en bdd
            $this->em->remove($categorie);
            $this->em->flush();

            $this->addFlash('success', 'Categorie supprimer  avec succes');
            return $this->redirectToRoute('admin.categories.index');
        }
        return $this->redirectToRoute('admin.categoriex.index');
    }
}
