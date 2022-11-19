<?php

namespace App\Service;

use App\Entity\Vote;
use App\Repository\ConcoursRepository;
use App\Repository\FamilleRepository;
use App\Repository\VoteRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;

class Utility
{
    private ConcoursRepository $concoursRepository;
    private FamilleRepository $familleRepository;
    private VoteRepository $voteRepository;

    public function __construct(ConcoursRepository $concoursRepository, FamilleRepository $familleRepository, VoteRepository $voteRepository)
    {
        $this->concoursRepository = $concoursRepository;
        $this->familleRepository = $familleRepository;
        $this->voteRepository = $voteRepository;
    }

    /**
     * @param $string
     * @return \Symfony\Component\String\AbstractUnicodeString
     */
    public function slugify($string)
    {
        $slugify = new AsciiSlugger();
        return $slugify->slug(strtolower($string));
    }

    /**
     * Generation du code de concours
     *
     * @param $entity
     * @return mixed
     */
    public function codeConcours($entity): mixed
    {
        $verif = $this->concoursRepository->findOneBy([],['id'=>"DESC"]);
        if (!$verif) $code = 1;
        else $code = (int) $verif->getId() +1;

        $reference = "S".$code;
        $entity->setCode($reference);

        return $entity;
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function codeFamille($entity): mixed
    {
        $verif = $this->familleRepository->findOneBy([],['id'=>'DESC']);
        if (!$verif) $id = 1;
        else $id = (int)$verif->getId() + 1;

        if (10 > $id) $code = '0'.$id;
        else $code = $id;

        // code du concours
        $concours = $entity->getConcours()->getCode();

        $entity->setCode($concours.''.$code);//dd($entity);

        return $entity;

    }

    /**
     * @param $famille
     * @param $telephone
     * @return bool
     */
    public function vote($famille, $telephone): bool
    {
        $concours =  $this->concoursRepository->findOneBy(['id'=>$famille->getConcours()]);
        $verif = $this->voteRepository->findOneBy(['concours' => $concours->getId(), 'telephone'=>$telephone]);
        if ($verif) return false;

        // Enregistrement
        $vote = new Vote();
        $vote->setTelephone($telephone);
        $vote->setFamille($famille);
        $vote->setConcours($concours);

        $this->voteRepository->save($vote, true);

        return true;
    }

    /**
     * verification de vote du telephone a ce concours
     * 
     * @param $famille
     * @param $telephone
     * @return bool
     */
    public function verificationVote($famille, $telephone): bool
    {
        $concours =  $this->concoursRepository->findOneBy(['id'=>$famille->getConcours()]);
        $verif = $this->voteRepository->findOneBy(['concours' => $concours->getId(), 'telephone'=>$telephone]);
        if ($verif) return true;
        else return false;

    }
}