<?php

namespace App\Controller\Frontend;

use App\Entity\Commentaires;
use App\Entity\Programme;
use App\Form\CommentaireType;
use App\Repository\CategorieRepository;
use App\Repository\CommentairesRepository;
use App\Repository\ExercicesRepository;
use App\Repository\ProgrammeMaisonRepository;
use App\Repository\ProgrammeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/programmes', 'user.programmes')]
class ProgrammeController extends AbstractController
{
    public function __construct(
        private readonly ProgrammeRepository $proRepo,
        private readonly CategorieRepository $categRepository,
        private readonly ExercicesRepository $exRepo,
        private readonly EntityManagerInterface $em,
        private readonly CommentairesRepository $commentRepo
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

    #[Route('/{slug}/list', name: '.list', methods: ['GET'])]
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



    #[Route('/{slug}/details', name: '.details', methods: ['GET','POST'])]
    public function details(string $slug, Request $request, ?Programme $programme): Response
    {
        $commentaire = new Commentaires();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {

            $commentaire
            ->setUser(
                $this->getUser()
            )
            ->setProgramme(
                $programme
            )
            ->setEnable(0);

            $this->em->persist($commentaire);
            $this->em->flush();

            $this->addFlash('success', 'commentaire creer avec succès');
            
        }


        $programme = $this->proRepo->findOneBy(['slug' => $slug]);
        $exercice = [];

        if ($programme) {
            $exercice = $programme->getExercices();
        }

        return $this->render('Frontend/Programme/detail.html.twig', [
            'exercices' => $exercice,
             'programme' => $programme,
             'form' => $form,
             'commentaires'=>$this->commentRepo->findAllByProgramme()
        ]);
    }
}
