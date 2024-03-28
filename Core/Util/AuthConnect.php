<?php

namespace Cineflix\Core\Util;

use Cineflix\Core\Database\Database;

class AuthConnect
{

    private static $_UserDao;
    private static $_Connect = false;
    private static $_NameSession;

    /**
     * @param string $table
     * @param string $name_session
     */
    public static function init($userDao, $nameSession = 'Auth')
    {
        self::$_UserDao = $userDao;

        self::$_NameSession = $nameSession;

        if (isset($_SESSION[self::$_NameSession]))
            self::$_Connect = true;
    }

    /**
     * @param string $col Colonne de la table
     * @param string $val Valeur de la colonne
     * @param string $pwd Mot de passe
     */
    public static function logon(string $colId, string $value, string $pwd): bool
    {

        //requete
        if ($user) {

            if (password_verify($pwd, $user->password))
                self::$_Connect = true;

        }

        return self::$_Connect;
    }

    /**
     * @param string $name_session nom de la session
     * @param array $params tableau des valeurs enregistré en session cles => valeurs
     */
    public static function connect(array $params): void
    {
        $_SESSION = [self::$_NameSession => $params];
    }

    /**
     * @param string $name_session nom de la session
     */
    public static function deconnect(): void
    {
        self::$_Connect = false;
        unset($_SESSION[self::$_NameSession]);
    }

    public static function isConnected(): bool
    {
        return self::$_Connect;
    }

    public static function getNameSession(): string
    {
        return self::$_NameSession;
    }
}