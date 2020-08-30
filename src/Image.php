<?php

namespace AsyncScraper;

final class Image
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string[]
     */
    public $nomcrypto;
    /**
     * @var string[]
     */
    public $montantcap;
    /**
     * @var string[]
     */
    public $prix;
    /**
     * @var string[]
     */
    public $montantvolume;
    /**
     * @var string[]
     */
    public $montantoffre;
    /**
     * @var string[]
     */
    public $montantvariation;
    /**
     * @var string[]
     */
    public $source;

    public function __construct(
        int $id,
        string $nomcrypto,
        string $montantcap,
        string $prix,
        string $montantvolume,
        string $montantoffre,
        string $montantvariation,
        string $source
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
