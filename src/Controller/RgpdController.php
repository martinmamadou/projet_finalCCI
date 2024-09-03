<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RgpdController extends AbstractController
{
    #[Route('/MentionsLegale', name: 'app.mention', methods:['GET'])]
    public function mention(): Response
    {
        return $this->render('rgpd/mention.html.twig', [
        ]);
    }
    #[Route('/conditions', name: 'app.condition', methods:['GET'])]
    public function condition(): Response
    {
        return $this->render('rgpd/condition.html.twig', [
        ]);
    }
    #[Route('/confidentialite', name: 'app.confidentialite', methods:['GET'])]
    public function confidentiaite(): Response
    {
        return $this->render('rgpd/confidentialite.html.twig', [
        ]);
    }
    #[Route('/About', name: 'app.about', methods:['GET'])]
    public function about(): Response
    {
        return $this->render('rgpd/about.html.twig', [
        ]);
    }
}
