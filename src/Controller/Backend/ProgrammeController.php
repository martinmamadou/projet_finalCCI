<?php

namespace App\Controller\Backend;

use App\Entity\Programme;
use App\Form\ProMaisonType;
use App\Entity\ProgrammeMaison;
use App\Entity\ProType;
use App\Repository\ExercicesRepository;
use App\Repository\ProgrammeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProgrammeMaisonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('admin/programmes', 'admin.programmes')]
class ProgrammeController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ProgrammeRepository $proRepository
    ) {
    }
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response|RedirectResponse
    {
        return $this->render('Backend/Programme/index.html.twig', [
            'programmes' => $this->proRepository->findAll()
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    {


        $programme = new Programme;
        $form = $this->createForm(ProMaisonType::class, $programme, ['isUser' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $programme->setUser($this->getUser());
            $this->em->persist($programme);
            $this->em->flush();
            
            $this->addFlash('success','programme créé avec succès');
            return $this->redirectToRoute('admin.membre.index');
        }


        return $this->render('Backend/Programme/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Programme $programme, Request $request): Response|RedirectResponse
    {
        if (!$programme) {
            $this->addFlash('error', 'programme inexistant');
            return $this->redirectToRoute('admin.programmes.index');
        }
        $form = $this->createForm(ProMaisonType::class, $programme);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($programme);
            $this->em->flush();

            $this->addFlash('success', 'programme modifié avec succès');
            return $this->redirectToRoute('admin.programmes.index');
        }
        return $this->render('Backend/Programme/edit.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/{id}/delete', '.delete', methods: ['GET', 'POST'])]
    public function delete(?Programme $programme, Request $request): Response|RedirectResponse
    {
        if (!$programme) {

            $this->addFlash('error', 'programme inexistant');
            return $this->redirectToRoute('admin.users.index');
        }
        if ($this->isCsrfTokenValid('delete' . $programme->getId(), $request->request->get('token'))) {

            //on supprime en bdd
            $this->em->remove($programme);
            $this->em->flush();

            $this->addFlash('success', 'programme supprimé  avec succes');
            return $this->redirectToRoute('admin.programmes.index');
        }
        return $this->redirectToRoute('admin.programmes.index');
    }
}
