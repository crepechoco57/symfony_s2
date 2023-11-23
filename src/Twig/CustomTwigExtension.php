<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

class CustomTwigExtension extends AbstractExtension{
    

    public function getFilters(){
        return [
            new TwigFilter('mon_filtre_twig', [$this,'monFiltreTwig']),
        ];
    }
public function monFiltreTwig($value){
    return ucfirst($value);
}

}