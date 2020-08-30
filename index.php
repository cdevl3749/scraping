<?php

use React\MySQL\QueryResult;

require __DIR__ . '/vendor/autoload.php';
//require __DIR__ . '/src/Scraper.php';

$loop = \React\EventLoop\Factory::create();
$browser = new \Clue\React\Buzz\Browser($loop);
$scraper = new \AsyncScraper\Scraper($browser);

$urls = [
    'https://coinmarketcap.com/fr/',
];

$storage = new \AsyncScraper\Storage($loop, 'root:blog@127.0.0.1/scraping?idle=0');

$scraper->scrape(...$urls)
    ->then(function (array $images) use ($storage) {
        //var_dump($images);
        $storage->save(...$images);
    });

$loop->run();
