<?php
require 'vendor/autoload.php';

use Symfony\Component\DomCrawler\Crawler;
use Curl\Curl;

$curl = new Curl();
$curl->get('https://github.com/trending');
$html = $curl->response;

$html = file_get_contents('data.html');
$crawler = new Crawler($html);

/** Get First Repository Title */
$firstPost = $crawler->filter('article.Box-row > h1 > a')->text();

/** Get title, link, stars for repositories */
$data = $crawler->filter('article.Box-row')->each(function ($node) {
    $anchorNode = $node->filter('h1 > a');
    $data['title'] = $anchorNode->text();
    $data['link'] = $anchorNode->attr('href');
    $data['stars'] = $node->filter('div.text-gray > a')->text();
    return $data;
});

