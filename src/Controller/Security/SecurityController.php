<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\SecurityType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserRepository $userRepo
    ) {
    }


    #[Route('/login', 'app.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUserName();

        return $this->render('Security/login.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error,
        ]);
    }


    #[Route('/register', name: 'app.register', methods: ['GET', 'POST'])]


    public function register(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User;
        $form = $this->createForm(SecurityType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user
                ->setEnable(true)
                ->setPassword($hasher->hashPassword($user, $form->get('password')->getData()));
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('app.login');
            $this->addFlash('success', 'inscription reussi');
        }

        return $this->render('Security/register.html.twig', [
            'form' => $form,
        ]);
    }
}
