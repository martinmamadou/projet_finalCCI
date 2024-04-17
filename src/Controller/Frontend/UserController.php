<?php

namespace App\Controller\Frontend;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/profile', 'user.profile')]
class UserController extends AbstractController
{
    #[Route('/{id}', name: '', methods:['GET','POST'])]
    public function show(?User $user): Response|RedirectResponse
    {
        if(!$user){
            $this->addFlash('danger', 'utilisateur inexistant');
            return $this->redirectToRoute('app.home');
        }

        return $this->render('Frontend/User/show.html.twig', [
            'user'=>$user
        ]);
    }
}
