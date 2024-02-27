<?php

namespace Cineflix\Core\Util;

class HelperDebug
{
    private static $called_fonctions = [];

    public static function debug()
    {
        register_shutdown_function();
    }
}