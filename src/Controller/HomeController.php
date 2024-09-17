<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProgrammeRepository;
use App\Repository\ProTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly ProTypeRepository $protype,
        private readonly ProgrammeRepository $programmeRepo
    ) {
    }
    #[Route('', name: 'app.landing')]
    public function landing(): Response
    {   
        return $this->render('Home/landing.html.twig', [
        ]);
    }

    #[Route('/home', name: 'app.home')]
    public function index(): Response
    {
       $programmes = $this->programmeRepo->findAllWithComments();
       $newPro = $this->programmeRepo->findByDate();
       
       
        
        return $this->render('Home/home.html.twig', [
            'protypes' => $this->protype->findAll(),
            'programmes' => $programmes,
            'news' => $newPro
        ]);
    }
}
