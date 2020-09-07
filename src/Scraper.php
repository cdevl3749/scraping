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

        $table = $crawler->filter('.cmc-details-panel-about__table > tr > td')->extract(['_text']);
        
        $id = (int)substr($table[2], 1);
        $nomcrypto = substr($crawler->filter('.bMKXnN h1')->text(), 0, -6);
        $montantcap = substr("$table[3]", 1, -4);//$crawler->filter('ul.dyvdrp li div span')->text();
        $prix = substr($table[0], 1, -4); //$crawler->filter('td.cmc-table__cell--sort-by__price')->text();
        $montantvolume = substr($table[4], 1, -4); // $crawler->filter('td.cmc-table__cell--sort-by__volume-24-h')->text();
        $montantoffre = substr($table[5], 0, -4); //$crawler->filter('td.cmc-table__cell--sort-by__circulating-supply')->text();
        $montantvariation = substr($crawler->filter('.cdygDb .cmc-details-panel-price__price-change')->text(), 1, -2); //$crawler->filter('td.cmc-table__cell--sort-by__percent-change-24-h')->text();
        $source = 'https://s2.coinmarketcap.com/static/img/coins/64x64/1.png';

        //var_dump($id, $nomcrypto, $montantcap, $prix, $montantvolume, $montantoffre, $montantvariation, $source);
        
        return new Image($id, $nomcrypto, $montantcap, $prix, $montantvolume, $montantoffre, $montantvariation, $source);
    }

    private function extractFormUrl($urls): PromiseInterface
    {
        return $this->browser->get($urls)->then(function (ResponseInterface $response) {
            return $this->extract((string) $response->getBody());
        });
    }
}
