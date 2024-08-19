<?php

namespace App\Controller\Frontend;

use App\Entity\Favoris;
use App\Entity\Programme;
use App\Entity\User;
use App\Repository\FavorisRepository;
use App\Repository\ProgrammeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/favoris', 'user.favoris')]
class FavorisController extends AbstractController
{

    public function __construct(
        private readonly  FavorisRepository $favRepo,
        private readonly EntityManagerInterface $em,
        private readonly ProgrammeRepository $proRepo
    ) {
    }
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(?Programme $programme): Response
    {

        $user = $this->getUser();

        if(!$user){
            $this->redirectToRoute('app.home');
        }
        

        return $this->render('Frontend/Favoris/index.html.twig', [
            'favoris' => $this->favRepo->findByUser($user),
            'programmes' => $programme
        ]);
    }

    #[Route('/{slug}/add', name: '.add', methods: ['GET', 'POST'])]
public function add(?Programme $programme, Request $request): Response|RedirectResponse
{
    if (!$programme) {
        $this->addFlash('error', 'Programme inexistant');
        return $this->redirectToRoute('admin.users.index');
    }

    if ($this->isCsrfTokenValid('add' . $programme->getSlug(), $request->request->get('token'))) {

        $favoris = $this->em->getRepository(Favoris::class)->findOneBy([
            'user' => $this->getUser(),
            'programme' => $programme
        ]) ?? new Favoris(); // Ternaire : récupère le Favoris s'il existe, sinon en crée un nouveau

        if (!$favoris->getId()) { // Si le Favoris est nouveau (sans ID)
            $favoris->setUser($this->getUser());
            $favoris->setProgramme($programme);

            $this->em->persist($favoris);
            $this->em->flush();

            $this->addFlash('success', 'Programme ajouté avec succès');
        } else {
            
            $this->addFlash('info', 'Programme déjà dans vos favoris');
            return $this->redirectToRoute('user.programmes.index');
        }

        return $this->redirectToRoute('user.favoris.index');
    }

    return $this->redirectToRoute('app.home');
}


    #[Route('/{id}/delete', '.delete', methods: ['GET', 'POST'])]
    public function delete(?Favoris $favoris, Request $request): Response|RedirectResponse
    {

        if (!$favoris) {
            $this->addFlash('error', 'programme inexistant');
            return $this->redirectToRoute('admin.users.index');
        }
        if ($this->isCsrfTokenValid('delete' . $favoris->getId(), $request->request->get('token'))) {
            $this->em->remove($favoris);
            $this->em->flush();

            $this->addFlash('success', 'programme supprimé avec succes');
            return $this->redirectToRoute('user.favoris.index');
        }
        return $this->redirectToRoute('app.home');
    }
  
}
