# Библиотека генерации карты сайта
Библиотека генерирует карту сайта в 3 форматах 

- CSV
- JSON
- XML

## SiteMap

Класс принимает 3 параметра:

- _список сайтов в виде массив с параметрами: адрес страницы (loc), дата изменения страницы (lastmod), приоритет парсинга (priority), периодичность обновления (changefreq)_
- _Тип выходного файла (csv, json, xml)_
- _Пути сохранения выходного файла (по умолчанию файл будет создан в той директории откуда запускается скрипт с именем result.тип файла)_

## Установка 
Требования: php>7.1.3, composer

```composer require meatqw/mapgen```

## Пример
```
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
```

