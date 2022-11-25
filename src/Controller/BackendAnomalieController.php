<?php

namespace App\Controller;

use App\Service\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend/anomalie')]
class BackendAnomalieController extends AbstractController
{
    private Utility $utility;

    public function __construct(Utility $utility)
    {
        $this->utility = $utility;
    }

    #[Route('/', name: 'app_backend_anomalie')]
    public function index():Response
    {
        $this->utility->addAnomalie();
        return $this->render('backend/anomalie.html.twig');
    }
}
