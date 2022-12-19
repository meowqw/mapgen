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

  // ИСПРАВЛЕНИЕ: Если путь не указан, файл будет создан в той директории откуда запускается скрипт с именем result.тип файла
  public function __construct($sitesData, $fileType, $savePath = "./")  
  {
    // Не пуст ли массив
    if (count($sitesData) == 0) {
      throw new ArrayEmpty();
    };


    // Проверка валидности ключей входного массива 
    foreach ($sitesData as $data) {

      $keys = array('loc', 'priority', 'changefreq', 'lastmod');
      $enteredDataKeys = array_keys($data);
      sort($keys);
      sort($enteredDataKeys);

      if ($enteredDataKeys != $keys) {
        throw new InValidArrayStructure();
        break; 
      };
        
    }

    $this->sitesData = $sitesData;
    $this->fileType = strtoupper($fileType);  // ИСПРАВЛЕНИЕ: Верхний регистр в switch
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
        throw new InValidFileType();
        
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
    // ИСПРАВЛЕНИЕ: Деление пути на имя и путь для создания директории если она отсутствует
    // Получение пути к файлу и имени файла 
    $arrayPath = explode('/', $this->savePath);
    $fileName = array_pop($arrayPath);
    $filePath = implode('/', $arrayPath);

    // Попытка создание папки
    if (!file_exists($filePath)) {
      if (!mkdir($filePath, 0777, true)) {  // ИСПРАВЛЕНИЕ: Правда доступа
        throw new IncorrectSavePath;
      };
    }
    
    // если путь не передан
    if ($this->savePath == "./") {
        $fileName = "result.$type";
    }

    // Возможно ли сохранить файл
    if (!file_put_contents("$filePath/$fileName", $data)) {
      throw new SaveError;
    }
    
    echo "File $this->savePath is saved\n";
  }
}
