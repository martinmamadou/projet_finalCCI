<?php

namespace App\Controller\Frontend;

use App\Repository\ExTemplateRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/exercice', 'exercice')]
class ExerciceController extends AbstractController
{
    public function __construct(
        private readonly ExTemplateRepository $exRepo
    ){

            
    }
    #[Route('', name: 'exercice.index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $this->exRepo->createQueryBuilder('e');

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            15 /*limit per page*/
        );

        return $this->render('frontend/exercice/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
