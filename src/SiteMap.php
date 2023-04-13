<?php

namespace Meowqw\Mapgen;

include 'FileController.php';
include 'MapGenerator.php';
include 'MyExceptions.php';


/**
 * Генерация карты сайта в форматах JSON, XML, CSV
 * class SiteMap
 * @package Meowqw\Mapgen
 */
class SiteMap
{
  // массив сайтов
  private array $sitesData;
  // тип выходного файла
  private string $fileType;
  // пути сохранения файла
  private string $savePath;

  // ИСПРАВЛЕНИЕ: Если путь не указан, файл будет создан в той директории откуда запускается скрипт с именем result.тип файла
  public function __construct($sitesData, $fileType, $savePath = "./")
  {
    // Не пуст ли массив
    if (count($sitesData) == 0) {
      throw new ArrayEmpty(); // исключение: пустой массив
    }


    // Проверка валидности ключей входного массива 
    foreach ($sitesData as $data) {

      $keys = array('loc', 'priority', 'changefreq', 'lastmod');
      $enteredDataKeys = array_keys($data);
      sort($keys);
      sort($enteredDataKeys);

      if ($enteredDataKeys != $keys) {
        throw new InValidArrayStructure(); // исключение: структура массива с данными о сайтах не корректна
      }

    }

    $this->sitesData = $sitesData;
    $this->fileType = strtoupper($fileType); // Верхний регистр в switch
    $this->savePath = $savePath;
  }

  /**
   * Генерация карты сайта.
   *
   * @throws InValidFileType Невалидный тип выходного файла.
   */
  public function getMap()
  {

    // генератор карты
    $mapGenerator = new MapGenerator;
    // управление файлами (сохранение)
    $fileController = new FileController;

    // Вызов метода согласно выбранному типу
    switch ($this->fileType) {
      case "XML":
        $data = $mapGenerator->generateToXML($this->sitesData);
        $fileController->save($data, 'xml', $this->savePath);
        break;
      case "CSV":
        $data = $mapGenerator->generateToCSV($this->sitesData);
        $fileController->save($data, 'csv', $this->savePath);
        break;
      case "JSON":
        $data = $mapGenerator->generateToJSON($this->sitesData);
        $fileController->save($data, 'json', $this->savePath);
        break;
      default:
        throw new InValidFileType(); // исключение: Невалидный тип выходного файла

    }
  }
}