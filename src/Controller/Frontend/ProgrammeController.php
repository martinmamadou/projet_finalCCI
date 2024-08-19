<?php

namespace App\Controller\Frontend;

use App\Entity\Categorie;
use App\Entity\ProType;
use App\Entity\Programme;
use App\Form\ProMaisonType;
use App\Entity\Commentaires;
use App\Form\CommentaireType;
use App\Repository\ProTypeRepository;
use App\Repository\CategorieRepository;
use App\Repository\ExercicesRepository;
use App\Repository\ProgrammeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentairesRepository;
use App\Repository\FavorisRepository;
use App\Repository\ProgrammeMaisonRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/programmes', 'user.programmes')]
class ProgrammeController extends AbstractController
{
    public function __construct(
        private readonly ProgrammeRepository $proRepo,
        private readonly CategorieRepository $categRepository,
        private readonly ExercicesRepository $exRepo,
        private readonly EntityManagerInterface $em,
        private readonly CommentairesRepository $commentRepo,
        private readonly ProTypeRepository $protype,
        private readonly FavorisRepository $favRepo,
    ) {
    }

    #[Route('/', name: '.index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        $programme = $this->proRepo->findAll();
        $user = $this->getUser();
        $favoritedProgrammes = [];
        $programmes = [];

        foreach ($programme as $programmes) {
            if ($this->favRepo->findByUser($user)) {
                $favoritedProgrammes[] = $programmes;
            }
        }

        return $this->render('Frontend/Programme/index.html.twig', [
            'programmes' => $programme,
            'categories' => $this->categRepository->findAll(),
            'protype' => $this->protype->findAll(),
            'favoris' => $favoritedProgrammes
        ]);
    }



    #[Route('/{type}/{slug}/list', name: '.list', methods: ['GET'])]
    public function list(string $slug, string $type, ?ProType $protype = null): Response
    {

        // Récupérer la catégorie correspondant au slug
        $categorie = $this->categRepository->findOneBy(["slug" => $slug]);

        // Récupérer le type de programme correspondant au slug
        $protype = $this->protype->findOneBy(["slug" => $type]);

        // Initialisez une variable pour stocker les programmes
        $programmes = [];

        // Vérifiez si la catégorie et le type de programme existent
        if ($protype) {
            $programmes = $this->proRepo->findBy(["proType" => $protype]);
            if ($categorie) {
                $programmes = $this->proRepo->findBy(["categorie" => $categorie]);
            }
            
        }
        
        $user = $this->getUser();
        $favoritedProgrammes = [];

        foreach ($programmes as $programme) {
            if ($this->favRepo->isFavoritedByUser($user, $programme)) {
                $favoritedProgrammes[] = $programme;
            }
        }

        // Renvoyez les données à la vue
        return $this->render('Frontend/Programme/list.html.twig', [
            'programmes' => $programmes,
            'categorie' => $categorie,
            'protype' => $protype,
            'favoris' => $favoritedProgrammes
        ]);
    }





    #[Route('/{slug}/details', name: '.details', methods: ['GET', 'POST'])]
    public function details(string $slug, Request $request, ?Categorie $categorie): Response
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
            $programme->addCommentaire($commentaire); // Appelle setMoyenne() via addCommentaire
            $this->em->flush();
            dd($programme);

            $this->addFlash('success', 'Commentaire créé avec succès');
        }

        $exercices = $programme->getExercices();
        $commentaires = $this->commentRepo->findAllByProgramme($programme);

        return $this->render('Frontend/Programme/detail.html.twig', [
            'exercices' => $exercices,
            'programme' => $programme,
            'form' => $form,
            'categorie' => $categorie,
            'commentaires' => $commentaires,
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $user = $this->getUser();
        if(!$user){
            $this->addFlash('error', 'Veuillez vous connectez');
            return $this->redirectToRoute('app.home');
        }
        $programme = new Programme;
        $form = $this->createForm(ProMaisonType::class, $programme, ['isUser' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($programme);
            $this->em->flush();
        }

        return $this->render('Frontend/Programme/create.html.twig', [
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

            $this->addFlash('success', 'programme modifier avec succès');
            return $this->redirectToRoute('admin.programmes.index');
        }
        return $this->render('Frontend/Programme/edit.html.twig', [
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

            $this->addFlash('success', 'programme supprimer  avec succes');
            return $this->redirectToRoute('admin.programmes.index');
        }
        return $this->redirectToRoute('admin.programmes.index');
    }
    #[Route('/preview','.preview')]
    public function preview(){
        
    }
}
