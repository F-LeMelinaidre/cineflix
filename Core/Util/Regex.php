<?php

namespace Cineflix\Core\Util;

use Error;

class Regex
{
    // Regex Email norme RFC2822
    // Validation mot de passe 8 caratères minimum et au moins un caratères majuscule, minuscule, un chiffre, et un caratères spéciaux !?:_\-*#&%+
    private const PATTERNS = [
        'alpha' => '/^[a-zA-Zàâçéèêëïîôùûüÿ\-\s]+$/',
        'alphaNumeric' => '/^[0-9a-zA-Zàâçéèêëïîôùûüÿ\-\s]+$/',
        'numeric' => '/^[0-9]+$/',
        'email'       => '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
        'password'   => '/^(?=.*[a-zA-Z0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[!?:_\-*#&%+]).{8,}$/'
    ];

    private const MESSAGES = [
        'alpha' => 'Caractères alphabétiques uniquement !',
        'alphaNumeric' => 'Caractères alpha-numériques uniquement !',
        'numeric' => 'Caractères numériques uniquement !',
        'email'       => 'Votre email ne respete pas la norme RFC2822',
        'password'   => '8 caratères minimum, comprenant au minimum une majascule, une minusclule, un chiffre, et un caratère !?:_-*#&%+'
    ];

    public static function getPattern(string $name): string
    {
        try {
            if (!array_key_exists($name, self::PATTERNS)) {
                throw new Error("Le pattern '$name' n'existe pas.");
            }
            return self::PATTERNS[$name];
        }
        catch (Error $e) {
            echo $e->getMessage();
            return '';
        }

    }

    public static function getMessage(string $name): string
    {
        try {
            if (!array_key_exists($name, self::MESSAGES)) {
                throw new Error("Le message pour le pattern '$name' n'existe pas.");
            }
            return self::MESSAGES[$name];
        }
        catch (Error $e) {
            echo $e->getMessage();
            return '';
        }
    }
}