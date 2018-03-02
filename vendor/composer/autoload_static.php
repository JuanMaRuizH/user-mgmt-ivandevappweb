<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita052612658a38f392a2b651a4ba59692
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

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita052612658a38f392a2b651a4ba59692::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita052612658a38f392a2b651a4ba59692::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
