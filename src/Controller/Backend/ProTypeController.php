<?php

namespace App\Controller\Backend;

use App\Entity\ProType;
use App\Form\ProTypeType;
use App\Repository\ProTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/protype', 'admin.protype')]
class ProTypeController extends AbstractController
{
    public function __construct(
        private readonly ProTypeRepository $protype,
        private readonly EntityManagerInterface $em
    ) {
    }
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response|RedirectResponse
    {
        return $this->render('Backend/Protype/index.html.twig', [
            'protypes' => $this->protype->findAll()
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $protype = new ProType;
        $form = $this->createForm(ProTypeType::class, $protype);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($protype);
            $this->em->flush();

            $this->addFlash('success','type créé avec succès');
            return $this->redirectToRoute('admin.membre.index');
        }

        return $this->render('Backend/ProType/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{slug}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?ProType $protype, Request $request): Response|RedirectResponse
    {
        if (!$protype) {
            $this->addFlash('error', 'type inexistant');
            return $this->redirectToRoute('admin.protype.index');
        }
        $form = $this->createForm(ProTypeType::class, $protype);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($protype);
            $this->em->flush();

            $this->addFlash('success', 'type modifié avec succès');
            return $this->redirectToRoute('admin.protype.index');
        }
        return $this->render('Backend/ProType/edit.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/{slug}/delete', '.delete', methods: ['GET', 'POST'])]
    public function delete(?ProType $protype, Request $request): Response|RedirectResponse
    {
        if (!$protype) {

            $this->addFlash('error', 'type inexistant');
            return $this->redirectToRoute('admin.protype.index');
        }
        if ($this->isCsrfTokenValid('delete' . $protype->getId(), $request->request->get('token'))) {

            //on supprime en bdd
            $this->em->remove($protype);
            $this->em->flush();

            $this->addFlash('success', 'type supprimé  avec succes');
            return $this->redirectToRoute('admin.protypes.index');
        }
        return $this->redirectToRoute('admin.protype.index');
    }
}
