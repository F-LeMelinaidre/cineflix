<?php

namespace Cineflix\Core\Util;

class Security
{

    private static array $Stores_Lib = [];
    private static string $Store;

    public static function sanitize($value): string
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    public static function getAndStoreToken(): string
    {
        $token = self::getToken();
        $_SESSION['tokens'][][] = $token;
        return $token;
    }

    public static function initTokenStore(string $index): void
    {
        self::$Stores_Lib[] = $index;
        self::$Store = $index;
        $_SESSION['tokens'][$index] = [];

    }
    public static function getToken(string $salt = null): string
    {
        $randomBytes = random_bytes(40);
        $token = rtrim(base64_encode($randomBytes), '=');

        return $token;
    }

}