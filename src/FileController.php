<?php
namespace Meowqw\Mapgen;

/**
 * Сохранение файла в форматах XML, JSON, XML
 * class MapGeneratorXML
 * @package Meowqw\Mapgen
 */
class FileController
{
    /**
     * Сохранение файла с картой сайта.
     * 
     * 
     * @param string $data Сгенерированны данные карты сайта.
     * @param string $type Тип с котором будет сохранен файл.
     * @param string $path Путь к файлу.
     * 
     * 
     * @throws SaveError Ошибка при сохранении файла.
     * @throws IncorrectSavePath Недопустимый путь.
     */
    public function save($data, $type, $path)
    {
        // Деление пути на имя и путь для создания директории если она отсутствует
        // Получение пути к файлу и имени файла 
        $arrayPath = explode('/', $path);
        $fileName = array_pop($arrayPath);
        $filePath = implode('/', $arrayPath);

        // Попытка создание папки
        if (!file_exists($filePath)) {
            if (!mkdir($filePath, 0644, true)) { // Правда доступа 0644
                throw new IncorrectSavePath; // исключение: Недопустимый путь
            }
            ;
        }

        // если путь не передан
        if ($path == "./") {
            $fileName = "result.$type";
        }

        // Возможно ли сохранить файл
        if (!file_put_contents("$filePath/$fileName", $data)) {
            throw new SaveError;  // исключение: Ошибка при сохранении файла
        }

        echo "File $path is saved\n";
    }

}