<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitabc974fa8d9817d5c587b31e2bdbf928
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'CustomPhpSettings\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'CustomPhpSettings\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'CustomPhpSettings\\Backend\\Backend' => __DIR__ . '/../..' . '/src/Backend/Backend.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitabc974fa8d9817d5c587b31e2bdbf928::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitabc974fa8d9817d5c587b31e2bdbf928::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitabc974fa8d9817d5c587b31e2bdbf928::$classMap;

        }, null, ClassLoader::class);
    }
}
