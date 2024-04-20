<?php

namespace App\Controller\Backend;

use App\Entity\ExerciceMaison;
use App\Form\ExMaisonType;
use App\Repository\ExerciceMaisonRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/exercices', 'admin.exercices')]
class ExercicesController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ExerciceMaisonRepository $exoRepo, 
    )
    {
        
    }

    #[Route('/index', name: '.index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Exercice/index.html.twig', [
            
           'exercices' => $this->exoRepo->findAll()
        ]);
    }


    #[Route('/create', '.create', methods:['GET','POST'])]
    public function create(Request $request): Response
    {
        $exercice = new ExerciceMaison;
        $form = $this->createForm(ExMaisonType::class, $exercice);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($exercice);
            $this->em->flush();
        }

        return $this->render('Backend/Exercice/create.html.twig', [
            'form' => $form
        ]);
    }
}
