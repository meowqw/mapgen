<?php
namespace Meowqw\Mapgen;

include 'MapTypeInterface.php';

/**
 * Генерация карты в формате XML, JSON, XML
 * class MapGeneratorXML
 * @package Meowqw\Mapgen
 */
class MapGenerator implements IMapTypeCSV, IMapTypeJSON, IMapTypeXML
{
    /**
     * Генерация карты в формате xml.
     * 
     * @param array $sitesData массив в набором данных о сайтах.
     *
     * 
     * @return string Строка которой содержит карту в формате xml .
     *
     */
    public function generateToXML($sitesData)
    {
        $xml = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' . "\n" .
            'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" ' . "\n" .
            'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9' . "\n" .
            'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";

        foreach ($sitesData as $data) {
            $xml = $xml . '<url>' . "\n" .
                '<loc>' . $data['loc'] . '</loc>' . "\n" .
                '<lastmod>' . $data['lastmod'] . '</lastmod>' . "\n" .
                '<priority>' . $data['priority'] . '</priority>' . "\n" .
                '<changefreq>' . $data['changefreq'] . '</changefreq>' . "\n" .
                '</url>' . "\n";
        }
        ;

        $xml = $xml . '</urlset>';
        return $xml;
    }

    /**
     * Генерация карты в формате json.
     *
     * @return string Строка которой содержит карту в формате json .
     *
     */
    public function generateToJSON($sitesData)
    {
        return json_encode($sitesData);
    }

    /**
     * Генерация карты в формате csv.
     *
     * @return string Строка которой содержит карту в формате csv .
     *
     */
    public function generateToCSV($sitesData)
    {
        $csv = 'loc;lastmod;priority;changefreq' . "\n";
        foreach ($sitesData as $data) {
            $csv = $csv . $data['loc'] . ';' . $data['lastmod'] . ';' . $data['priority'] . ';' . $data['changefreq'] . "\n";
        }
        return $csv;
    }


}