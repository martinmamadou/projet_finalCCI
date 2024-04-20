<?php

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Form\SecurityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[Route('/user/profile', 'user.profile')]
class UserController extends AbstractController


{

    public function __construct(
        private readonly EntityManagerInterface $em
        
    )
    {
        
    }
    #[Route('/{id}', name: '', methods: ['GET', 'POST'])]
    public function show(?User $user): Response|RedirectResponse
    {
        if (!$user) {
            $this->addFlash('error', 'utilisateur inexistant');
            return $this->redirectToRoute('app.home');
        }

        return $this->render('Frontend/User/show.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/edit/{id}','.edit', methods:['GET','POST'])]
    public function edit(?User $user, Request $request, UserPasswordHasherInterface $hasher):Response|RedirectResponse
    {
        if (!$user) {
            $this->addFlash('error', 'utilisateur inexistant');
            return $this->redirectToRoute('app.home');
        }

        $form = $this->createForm(SecurityType::class, $user, ['isAdmin' => false]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $user
            ->setPassword($hasher->hashPassword($user, $form->get('password')->getData()));
            $this->em->persist($user);
            $this->em->flush();
            
            $this->addFlash('success','Utilisateur modifier avec succès');
           return $this->redirectToRoute('app.home');
        }

        return $this->render('Frontend/User/edit.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }
}
