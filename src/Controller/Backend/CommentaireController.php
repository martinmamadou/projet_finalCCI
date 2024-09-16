<?php

namespace App\Controller\Backend;

use App\Entity\Commentaires;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/commentaire', 'admin.commentaire')]
class CommentaireController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly CommentairesRepository $commentaireRepo,
    ){
        
    }
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('backend/commentaire/index.html.twig', [
            'commentaires' => $this->commentaireRepo->findAll(),
        ]);
    }

    #[Route('/{id}/delete', '.delete', methods: ['GET', 'POST'])]
    public function delete(?Commentaires $commentaire, Request $request): Response|RedirectResponse
    {
        if (!$commentaire) {

            $this->addFlash('error', 'commenttaire inexistant');
            return $this->redirectToRoute('admin.commentaire.index');
        }
        if ($this->isCsrfTokenValid('delete' . $commentaire->getId(), $request->request->get('token'))) {

            //on supprime en bdd
            $this->em->remove($commentaire);
            $this->em->flush();

            $this->addFlash('success', 'commentaire supprimé  avec succes');
            return $this->redirectToRoute('admin.commentaire.index');
        }
    }
}
