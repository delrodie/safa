<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Repository\VoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend/vote')]
class BackendVoteController extends AbstractController
{
    #[Route('/{id}', name: 'app_backend_vote', methods: ['GET'])]
    public function index(Vote $vote): Response
    {
        return $this->render('backend/vote.html.twig',[
            'vote' => $vote
        ]);
    }
    
    #[Route('/{id}', name:'app_backend_vote_delete', methods: ['POST'])]
    public function delete(Request $request, Vote $vote, VoteRepository $voteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vote->getId(), $request->request->get('_token')))
            $voteRepository->remove($vote, true);

        return $this->redirectToRoute('app_backend_concours_show',['slug' => $vote->getConcours()->getSlug()], Response::HTTP_SEE_OTHER);
    }
}
