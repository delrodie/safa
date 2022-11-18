<?php

namespace App\Service;

use App\Repository\ConcoursRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;

class Utility
{
    private ConcoursRepository $concoursRepository;

    public function __construct(ConcoursRepository $concoursRepository)
    {
        $this->concoursRepository = $concoursRepository;
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
}