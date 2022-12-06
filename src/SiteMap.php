<?php

namespace Meatqw\Mapgen;

include 'MyExceptions.php';


/**
 * Генерация карты сайта в форматах JSON, XML, CSV
 * class SiteMap
 * @package Meatqw\Mapgen
 */
class SiteMap
{
  // массив сайтов
  private array $sitesData;
  // тип выходного файла
  private string $fileType;
  // пути сохранения файла
  private string $savePath;

  public function __construct($sitesData, $fileType, $savePath = '')
  {
    // Не пуст ли массив
    try {
      if (count($sitesData) == 0) {
        throw new ArrayEmpty();
      }
    } catch (ArrayEmpty $e) {
      echo $e->getMessage();
      die();
    };


    // Проверка валидности ключей входного массива 
    foreach ($sitesData as $data) {

      $keys = array('loc', 'priority', 'changefreq', 'lastmod');
      $enteredDataKeys = array_keys($data);
      sort($keys);
      sort($enteredDataKeys);

      try {
        if ($enteredDataKeys != $keys) {
          throw new InValidArrayStructure();
          break;
        }
      } catch (InValidArrayStructure $e) {
        echo $e->getMessage();
        die();
      }
    }

    $this->sitesData = $sitesData;
    $this->fileType = $fileType;
    $this->savePath = $savePath;
  }

  public function getMap()
  {
    // Вызов метода согласно выбранному типу
    switch ($this->fileType) {
      case "XML":
        $data = $this->genTypeXML();
        $this->saveFile($data, 'xml');
        break;
      case "CSV":
        $data = $this->genTypeCSV();
        $this->saveFile($data, 'csv');
        break;
      case "JSON":
        $data = $this->genTypeJSON();
        $this->saveFile($data, 'json');
        break;
      default:
        // Невалидный тип выходного файла
        try {
          throw new InValidFileType();
        } catch (InValidFileType $e) {
          echo $e->getMessage();
          die();
        }
    }
  }

  /**
   * Генерация JSON файла
   * @return string - json
   */
  public function genTypeJSON()
  {
    return json_encode($this->sitesData);
  }

  /**
   * Генерация XML файла
   * @return string - текст в форме XML
   */
  public function genTypeXML()
  {
    $xml = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' . "\n" .
      'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" ' . "\n" .
      'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9' . "\n" .
      'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";

    foreach ($this->sitesData as $data) {
      $xml = $xml . '<url>' . "\n" .
        '<loc>' . $data['loc'] . '</loc>' . "\n" .
        '<lastmod>' . $data['lastmod'] . '</lastmod>' . "\n" .
        '<priority>' . $data['priority'] . '</priority>' . "\n" .
        '<changefreq>' . $data['changefreq'] . '</changefreq>' . "\n" .
        '</url>' . "\n";
    };

    $xml = $xml . '</urlset>';
    return $xml;
  }


  /**
   * Генерация CVS файла
   * @return string - текст в форме XML
   */
  public function genTypeCSV()
  {
    $csv = 'loc;lastmod;priority;changefreq' . "\n";
    foreach ($this->sitesData as $data) {
      $csv = $csv . $data['loc'] . ';' . $data['lastmod'] . ';' . $data['priority'] . ';' . $data['changefreq'] . "\n";
    };

    return $csv;
  }

  /** 
   * Сохранение данных в файл и создание папки согласно указанному путиъ
   * @param string $data - данные для записи
   * @param string $type - тип выходного файла
  */
  public function saveFile($data, $type)
  {
    // Попытка создание папки
    if (!file_exists($this->savePath)) {
      try {
        if (!mkdir($this->savePath, 0777, true)) {
          throw new IncorrectSavePath;
        }
      } catch (IncorrectSavePath $e) {
        echo $e->getMessage();
        die();
      }
    }

    // Добавление / в конце пути если он отсутствует
    if (substr($this->savePath, -1) != '/') {
      $this->savePath .= '/';
    }

    // Возможно ли сохранить файл
    try {
      if (!file_put_contents($this->savePath . 'result.' . $type, $data)) {
        throw new SaveError;
      }
    } catch (SaveError $e) {
      echo $e->getMessage();
      die();
    }


    echo "File result.$type is saved\n";
  }
}
