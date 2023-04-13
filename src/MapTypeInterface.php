<?php
namespace Meowqw\Mapgen;

/**
 * Интерфейс генератора в формат XML
 * interface IMapTypeXML
 * @package Meowqw\Mapgen
 */
interface IMapTypeXML
{
    public function generateToXML();
}

/**
 * Интерфейс генератора в формат JSON
 * interface IMapTypeJSON
 * @package Meowqw\Mapgen
 */
interface IMapTypeJSON
{
    public function generateToJSON();
}

/**
 * Интерфейс генератора в формат CSV
 * interface IMapTypeCSV
 * @package Meowqw\Mapgen
 */
interface IMapTypeCSV
{
    public function generateToCSV();
}
?>