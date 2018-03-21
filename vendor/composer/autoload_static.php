<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4538d86e0ccd87171353e4fcbdbebbd1
{
    public static $prefixLengthsPsr4 = array (
        'e' => 
        array (
            'eftec\\' => 6,
        ),
        'D' => 
        array (
            'Dotenv\\' => 7,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'eftec\\' => 
        array (
            0 => __DIR__ . '/..' . '/eftec',
            1 => __DIR__ . '/..' . '/eftec/bladeone/vendor/eftec',
        ),
        'Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/clases',
        ),
    );

    public static $prefixesPsr0 = array (
        'V' => 
        array (
            'Valitron' => 
            array (
                0 => __DIR__ . '/..' . '/vlucas/valitron/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4538d86e0ccd87171353e4fcbdbebbd1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4538d86e0ccd87171353e4fcbdbebbd1::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit4538d86e0ccd87171353e4fcbdbebbd1::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
