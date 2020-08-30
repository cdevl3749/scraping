<?php

namespace AsyncScraper;

use AsyncScraper\Image;
use Clue\React\Buzz\Browser;
use function React\Promise\all;

use React\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

final class Scraper
{
    private $browser;

    public function __construct(Browser $browser)
    {
        $this->browser = $browser;
    }

    public function scrape(string ...$urls): PromiseInterface
    {
        $promises = array_map(function ($urls) {
            return $this->extractFormUrl($urls);
        }, $urls);

        return all($promises);
    }

    private function extract(string $responseBody): Image
    {
        $crawler = new Crawler($responseBody);

        // id - ?
        // nomcrypto - a.cmc-link
        // montantcap - p.hVAibX
        // prix - td.cmc-table__cell--sort-by__price
        // montantvolume - td.cmc-table__cell--sort-by__volume-24-h
        // montantoffre - td.cmc-table__cell--sort-by__circulating-supply
        // montantvariation - td.cmc-table__cell--sort-by__percent-change-24-h
        // img - img.cmc-static-icon-1

        $id = $crawler->filter('td.cmc-table__cell--sort-by__rank')->text();
        $nomcrypto = $crawler->filter('a.cmc-link')->text();
        $montantcap = $crawler->filter('p.hVAibX')->text();
        $prix = $crawler->filter('td.cmc-table__cell--sort-by__price')->text();
        $montantvolume = $crawler->filter('td.cmc-table__cell--sort-by__volume-24-h')->text();
        $montantoffre = $crawler->filter('td.cmc-table__cell--sort-by__circulating-supply')->text();
        $montantvariation = $crawler->filter('td.cmc-table__cell--sort-by__percent-change-24-h')->text();
        $link = $crawler->filter('img.cmc-static-icon-1');
        $source = $link->attr('src');

        //$id = mt_rand(0, 10);
        //print_r($nomcrypto);
        return new Image($id, $nomcrypto, $montantcap, $prix, $montantvolume, $montantoffre, $montantvariation, $source);
    }

    private function extractFormUrl($urls): PromiseInterface
    {
        return $this->browser->get($urls)->then(function (ResponseInterface $response) {
            return $this->extract((string) $response->getBody());
        });
    }
}
