<?php

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Form\InfoType;
use App\Entity\UserInfo;
use App\Form\SecurityType;
use App\Repository\FavorisRepository;
use App\Repository\ProgrammeRepository;
use App\Repository\UserInfoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[Route('/user/profile', 'user.profile')]
class UserController extends AbstractController


{

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserInfoRepository $UserInfoRepository,
        private readonly FavorisRepository $favRepo,
        private readonly ProgrammeRepository $proRepo,

    ) {}
    #[Route('', name: '.index', methods: ['GET', 'POST'])]
    public function show(?User $user, ?UserInfo $info): Response|RedirectResponse
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', ' Veuillez vous connecter. ');
            return $this->redirectToRoute('app.home');
        }
        $favoris = $this->favRepo->findByUser($user);



        return $this->render('Frontend/User/show.html.twig', [
            'user' => $user,
            'info' => $info,
            'favoris' => $favoris,
            'programme' => $this->proRepo->findAll(),
        ]);
    }

    #[Route('/edit/{id}', '.edit', methods: ['GET', 'POST'])]
    public function edit(?User $user, Request $request, UserPasswordHasherInterface $hasher): Response|RedirectResponse
    {
        if (!$user) {
            $this->addFlash('error', 'utilisateur inexistant');
            return $this->redirectToRoute('app.home');
        }

        $form = $this->createForm(SecurityType::class, $user, ['isAdmin' => false]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user
                ->setPassword($hasher->hashPassword($user, $form->get('password')->getData()));
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'Utilisateur modifier avec succès');
            return $this->redirectToRoute('app.home');
        }

        return $this->render('Frontend/User/edit.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }

    #[Route('/infos/{id}', '.infos', methods: ['GET', 'POST'])]
    public function infos(Request $request, ?User $user): Response|RedirectResponse
    {

        $info = $user->getUserInfo() ?? new UserInfo();

        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $info->setUser($user);

            $this->em->persist($info);
            $this->em->flush();

            $this->addFlash('success', 'Utilisateur modifier avec succès');
            return $this->redirectToRoute('app.home');
        }
        return $this->render('Frontend/User/info.html.twig', [
            'user' => $user,
            'info' => $info,
            'form' => $form
        ]);
    }
    #[Route('/{id}/delete', '.delete', methods: ['GET', 'POST'])]
    public function delete(?User $user, Request $request, Security $security): Response|RedirectResponse
    {
        if (!$user) {

            $this->addFlash('error', 'Utilisateur inexistant');
            return $this->redirectToRoute('app.profile');
        }
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('token'))) {

            //on supprime en bdd
            $this->em->remove($user);
            $this->em->flush();

           
            // Déconner l'utilisateur
            $security->logout(false); 
            $this->addFlash('success', 'Utilisateur supprimé avec succes');
            return $this->redirectToRoute('app.landing');
        }
    }
}
