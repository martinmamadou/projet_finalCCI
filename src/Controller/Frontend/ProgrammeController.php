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
    public function index(string $type): Response
{
    // Vérifiez le type pour charger les programmes correspondants
    if ($type === 'gym') {
        $programmes = $this->proRepo->findBy(['type' => 'gym']);
    } elseif ($type === 'home') {
        $programmes = $this->proRepo->findBy(['type' => 'home']);
    } else {
        // Gérez le cas où le type n'est ni "salle" ni "maison"
        throw $this->createNotFoundException('Type non valide');
    }

    return $this->render('Frontend/Programme/index.html.twig', [
        'programmes' => $programmes,
        'categories' => $this->categRepository->findAll()
    ]);
}


#[Route('/{slug}/{type}/list', name: '.list', methods: ['GET'])]
public function list(string $slug, string $type): Response
{
    // Récupérez la catégorie correspondant au slug
    $categorie = $this->categRepository->findOneBy(['slug' => $slug]);

    // Initialisez une variable pour stocker les programmes
    $programmes = [];

    if ($categorie) {
        // Récupérez les programmes de la catégorie en fonction du type
        $programmes = $this->proRepo->findBy(['categorie' => $categorie, 'type' => $type]);
    }

    // Renvoyez les données à la vue
    return $this->render('Frontend/Programme/list.html.twig', [
        'programmes' => $programmes,
        'categorie' => $categorie,
    ]);
}





    #[Route('/{slug}/details', name: '.details', methods: ['GET','POST'])]
    public function details(string $slug, Request $request): Response
    {
        $programme = $this->proRepo->findOneBy(['slug' => $slug]);
    
        if (!$programme) {
            $this->addFlash('error', 'Programme non trouvé');
            return $this->redirectToRoute('user.programmes.index');
        }
    
        $commentaire = new Commentaires();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire
                ->setUser($this->getUser())
                ->setProgramme($programme)
                ->setEnable(0);
    
            $this->em->persist($commentaire);
            $this->em->flush();
    
            $this->addFlash('success', 'Commentaire créé avec succès');
        }
    
        $exercices = $programme->getExercices();
        $commentaires = $this->commentRepo->findAllByProgramme($programme);
    
        return $this->render('Frontend/Programme/detail.html.twig', [
            'exercices' => $exercices,
            'programme' => $programme,
            'form' => $form,
            'commentaires' => $commentaires,
        ]);
    }
    
}
