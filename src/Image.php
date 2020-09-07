<?php

namespace AsyncScraper;

final class Image
{
    
    public $id;
    
    public $nomcrypto;
    
    public $montantcap;
   
    public $prix;
    
    public $montantvolume;
    
    public $montantoffre;
    
    public $montantvariation;
    
    public $source;

    public function __construct(
        int $id,
        $nomcrypto,
        $montantcap,
        $prix,
        $montantvolume,
        $montantoffre,
        $montantvariation,
        $source
    ) {
        $this->id = $id;
        $this->nomcrypto = $nomcrypto;
        $this->montantcap = $montantcap;
        $this->prix = $prix;
        $this->montantvolume = $montantvolume;
        $this->montantoffre = $montantoffre;
        $this->montantvariation = $montantvariation;
        $this->source = $source;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nomcrypto' => $this->nomcrypto,
            'montantcap' => $this->montantcap,
            'prix' => $this->prix,
            'montantvolume' => $this->montantvolume,
            'montantoffre' => $this->montantoffre,
            'montantvariation' => $this->montantvariation,
            'source' => $this->source
        ];
    }
}
