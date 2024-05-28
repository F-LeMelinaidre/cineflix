<?php

    namespace Cineflix\Core\Util;

    class Code
    {

        public static function getCode(string $value, int $length = 2): string
        {
            $value = str_replace(' ', '', $value);

            return strtoupper(substr($value, 0, $length));

        }
    }