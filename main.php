<?php

use Meatqw\Mapgen\SiteMap;
require_once 'vendor/autoload.php';


$sites = array(
    array(
        'loc' => 'https://site.ru/',
        'lastmod' => '2020-12-14',
        'priority' => 1,
        'changefreq' => 'hourly'
    ),
    array(
        'loc' => 'https://site2.ru/',
        'lastmod' => '2021-10-14',
        'priority' => 0.5,
        'changefreq' => 'weekly'
    )
);

// генерация xml
$map  = new SiteMap($sites, "XML", './result/res.xml');
$map->getmap();

// генерация json
$map  = new Sitemap($sites, "JSON");
$map->getmap();

// генерация csv
$map  = new Sitemap($sites, "csv", './result.csv');
$map->getmap();
