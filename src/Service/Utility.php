<?php

namespace App\Service;

use Symfony\Component\String\Slugger\AsciiSlugger;

class Utility
{
    /**
     * @param $string
     * @return \Symfony\Component\String\AbstractUnicodeString
     */
    public function slugify($string)
    {
        $slugify = new AsciiSlugger();
        return $slugify->slug(strtolower($string));
    }
}