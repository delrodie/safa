<?php

namespace App\Controller;

use App\Entity\Famille;
use App\Repository\FamilleRepository;
use App\Service\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vote')]
class VoteController extends AbstractController
{
    private FamilleRepository $familleRepository;
    private Utility $utility;

    public function __construct(FamilleRepository $familleRepository, Utility $utility)
    {
        $this->familleRepository = $familleRepository;
        $this->utility = $utility;
    }

    #[Route('/', name: 'app_vote', methods: ['GET','POST'])]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->get('famille'))
            return $this->redirectToRoute('app_home');
        else
            $famille = $this->familleRepository->findOneBy(['slug' => $session->get('famille')]);

        if ($request->request->get('_telephone') and $request->request->get('_csrf_token')){
            $session->set('telephone', $request->request->get('_telephone'));
            return $this->redirectToRoute('app_vote_show', ['slug' => $famille->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vote/index.html.twig', [
            'famille' => $famille,
        ]);
    }

    #[Route('/{slug}', name:'app_vote_show', methods:['GET','POST'])]
    public function couple(Request $request, Famille $famille): Response
    {
        $session = $request->getSession();
        // Affectation de la famille à la session
        $session->set('famille', $famille->getSlug());

        if (!$session->get('telephone'))
            return $this->redirectToRoute('app_vote', [], Response::HTTP_SEE_OTHER);
        //else
        //dd($request);
        if ($request->request->get('_couple') and $request->request->get('_csrf_token')){
            $this->utility->vote($famille, $session->get('telephone'));
        }

        return $this->render('vote/couple.html.twig',[
            'famille' => $famille
        ]);
    }
}
