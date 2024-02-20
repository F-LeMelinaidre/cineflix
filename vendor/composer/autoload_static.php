<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc813a22344b2a2d2ad8b6ebeb1041bb9
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Cineflix\\Core\\' => 14,
            'Cineflix\\App\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Cineflix\\Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Core',
        ),
        'Cineflix\\App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc813a22344b2a2d2ad8b6ebeb1041bb9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc813a22344b2a2d2ad8b6ebeb1041bb9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc813a22344b2a2d2ad8b6ebeb1041bb9::$classMap;

        }, null, ClassLoader::class);
    }
}
