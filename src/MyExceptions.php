<?php

namespace Meatqw\Mapgen;

use Exception;

class ArrayEmpty extends Exception
{
    public function __construct()
    {
        parent::__construct("Массив пуст");
    }
}

class InValidFileType extends Exception
{
    public function __construct()
    {
        parent::__construct("Некорректный тип данных (JSON, XML, CSV)");
    }
}

class InValidArrayStructure extends Exception
{
    public function __construct()
    {
        parent::__construct("Невалидные данные ('loc', 'priority', 'changefreq', 'lastmod')");
    }
}

class IncorrectSavePath extends Exception
{
    public function __construct()
    {
        parent::__construct("Путь не существует/недоступен и его создание невозможно");
    }
}

class SaveError extends Exception
{
    public function __construct()
    {
        parent::__construct("Ошибка при сохранении");
    }
}

class FilePathNotFolder extends Exception
{
    public function __construct()
    {
        parent::__construct("Указанный путь не ведет к папке");
    }
}
