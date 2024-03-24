<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Form\SecurityType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/users', 'admin.users')]
class UserController extends AbstractController
{
    public function __construct(private UserRepository $userRepo, private EntityManagerInterface $em)
    {
        
    }
    #[Route('/index', name: '.index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/User/index.html.twig', [
            'users' => $this->userRepo->findAll()
        ]);
    }

    #[Route('/{id}/edit', '.edit', methods:['GET','POST'])]
    public function edit(?User $user, Request $request):Response|RedirectResponse{
        if(!$user){
            return $this->redirectToRoute('admin.users.index');
        }
        $form = $this->createForm(SecurityType::class, $user, ['isAdmin' => true]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($user);
            $this->em->flush();

           return $this->redirectToRoute('admin.users.index');
        }
        return $this->render('Backend/User/edit.html.twig',[
            'form' => $form
        ]);

       
        
    }
    #[Route('/{id}/delete', '.delete', methods:['GET','POST'])]
    public function delete(?User $user, Request $request):Response|RedirectResponse{
        if(!$user){
            return $this->redirectToRoute('admin.users.index');
        }
        if($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('token'))) {

            //on supprime en bdd
            $this->em->remove($user);
            $this->em->flush();

            
        }
        return $this->redirectToRoute('admin.users.index');
    }
}

