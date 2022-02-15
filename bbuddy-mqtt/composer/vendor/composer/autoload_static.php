<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit521c0ce8fe69bcf2e77b9ca3e2548bfc
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'PhpMqtt\\Client\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'PhpMqtt\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-mqtt/client/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit521c0ce8fe69bcf2e77b9ca3e2548bfc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit521c0ce8fe69bcf2e77b9ca3e2548bfc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit521c0ce8fe69bcf2e77b9ca3e2548bfc::$classMap;

        }, null, ClassLoader::class);
    }
}