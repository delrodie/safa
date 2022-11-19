<?php

namespace App\Controller;

use App\Repository\FamilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private FamilleRepository $familleRepository;

    public function __construct(FamilleRepository $familleRepository, )
    {
        $this->familleRepository = $familleRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'familles' => $this->familleRepository->findAll(),
        ]);
    }
}
