<?php

namespace Cineflix\Core\Util;

class Security
{

    public static function sanitize($value): string
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value, ENT_NOQUOTES, 'UTF-8');
        return $value;
    }

}