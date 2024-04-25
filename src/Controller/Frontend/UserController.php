<?php

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Form\InfoType;
use App\Entity\UserInfo;
use App\Form\SecurityType;
use App\Repository\UserInfoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[Route('/user/profile', 'user.profile')]
class UserController extends AbstractController


{

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserInfoRepository $UserInfoRepository

    ) {
    }
    #[Route('/{id}', name: '', methods: ['GET', 'POST'])]
    public function show(?User $user, ?UserInfo $info): Response|RedirectResponse
    {
        if (!$user) {
            $this->addFlash('error', 'utilisateur inexistant');
            return $this->redirectToRoute('app.home');
        }

        return $this->render('Frontend/User/show.html.twig', [
            'user' => $user,
            'info' => $info
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
        $info = new UserInfo;

        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
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
    #[Route('/infos/delete/{id}', '.infos.delete', methods: ['POST'])]
    public function infoDel(Request $request, ?User $user, ?UserInfo $info): Response|RedirectResponse
    {

        if (!$user) {
            $this->addFlash('error', 'utilisateur inexistant');
            return $this->redirectToRoute('app.home');
        }

        if ($this->isCsrfTokenValid('delete' . $info->getId(), $request->request->get('token'))) {
            $user
                ->setUserInfo($info);
            if ($info !== null) {
                $this->em->remove($info);
                $this->em->flush();

                $this->addFlash('success', 'Informations utilisateur supprimées avec succès');
                return $this->redirectToRoute('app.home');
            } else {
                // Gérer le cas où $info est null, peut-être rediriger avec un message d'erreur
                dump($info);
                return $this->redirectToRoute('app.home');
            }
        }
        return $this->redirectToRoute('app.user.profile');
    }
}
