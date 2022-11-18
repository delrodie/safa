<?php

namespace App\Service;

use App\Repository\ConcoursRepository;
use App\Repository\FamilleRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;

class Utility
{
    private ConcoursRepository $concoursRepository;
    private FamilleRepository $familleRepository;

    public function __construct(ConcoursRepository $concoursRepository, FamilleRepository $familleRepository)
    {
        $this->concoursRepository = $concoursRepository;
        $this->familleRepository = $familleRepository;
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
}