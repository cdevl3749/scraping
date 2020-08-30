<?php

// https://www.pexels.com/photo/adorable-animal-blur-cat-617278/

use Clue\React\Buzz\Browser;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

require __DIR__ . '/vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$browser = new Browser($loop);
$browser
  ->get('https://coinmarketcap.com/fr/')
  ->then(function (ResponseInterface $response) {
    $crawler = new Crawler((string) $response->getBody());

    // txt_marcher - th.cmc-table__cell--sort-by__market-cap
    // mnt_marcher - p.hVAibX

    $txt_marcher = $crawler->filter('th.cmc-table__cell--sort-by__market-cap')->text();
    $mnt_marcher = $crawler->filter('p.hVAibX')->text();

    print_r([
      $txt_marcher,
      $mnt_marcher
    ]);
  });

$loop->run();
