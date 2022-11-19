<?php

namespace App\Controller;

use App\Repository\FamilleRepository;
use App\Service\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private FamilleRepository $familleRepository;
    private Utility $utility;

    public function __construct(FamilleRepository $familleRepository, Utility $utility)
    {
        $this->familleRepository = $familleRepository;
        $this->utility = $utility;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'familles' => $this->utility->listFamilleByConcoursActif(),
        ]);
    }
}
