<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdd6cc8f5e87b2d068024a5043acc6d87
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Meatqw\\Mapgen\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Meatqw\\Mapgen\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdd6cc8f5e87b2d068024a5043acc6d87::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdd6cc8f5e87b2d068024a5043acc6d87::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdd6cc8f5e87b2d068024a5043acc6d87::$classMap;

        }, null, ClassLoader::class);
    }
}