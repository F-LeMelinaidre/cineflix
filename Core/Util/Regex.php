<?php

    namespace Cineflix\Core\Util;

    class Regex
    {
        // Regex Email norme RFC2822
        // Validation mot de passe 8 caratères minimum et au moins un caratères majuscule, minuscule, un chiffre, et un caratères spéciaux !?:_\-*#&%+
        private const PATTERNS = [
            'carateres' => '/[a-zA-Zàâçéèêëïîôùûüÿ\-\s]+/',
            'mail'       => '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
            'password'   => '/^(?=.*[a-zA-Z0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[!?:_\-*#&%+]).{8,}$/'
        ];

        public static function getPattern(string $name): string
        {
            if (!array_key_exists($name, self::PATTERNS)) {
                trigger_error("Le pattern '$name' n'existe pas.", E_USER_ERROR); // Affiche une Erreur
                return '';
            }
            return self::PATTERNS[$name];

        }
    }