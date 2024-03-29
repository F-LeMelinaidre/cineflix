<?php

namespace Cineflix\Core\Util;

use Cineflix\Core\Database\Database;

/**
 *
 */
class AuthConnect
{

    private static $_Database;
    private static $_Model;
    private static $_Table;
    private static $_Connect = false;
    private static $_NameSession;

    /**
     * @param Database $database Instance de Database
     * @param String $name_session Nom de Session
     *
     * @return void
     */
    public static function init($database, $model, $table, $name_session = 'Auth')
    {
        self::$_Database = $database;
        self::$_Model = $model;
        self::$_Table = $table;

        self::$_NameSession = $name_session;

        if (isset($_SESSION[self::$_NameSession]))
            self::$_Connect = true;
    }

    /**
     * @param string $col_name Colonne de la table
     * @param string $value Valeur de la colonne
     * @param string $pwd Mot de passe
     */
    public static function logon(string $col_name, string $value, string $pwd): bool
    {

        $table = self::$_Table;

        $query ="SELECT $col_name, password FROM $table WHERE $col_name LIKE :$col_name";
        $bindValues[] = ['col' => $col_name, 'val' => $value];

        $req = self::$_Database->prepare($query, $bindValues);
        $result = $req->fetch(self::$_Model);


        if ($result && password_verify($pwd, $result->password)) {
            self::$_Connect = true;

        }

        return self::$_Connect;
    }

    /**
     * $_NameSession nom de la session
     * @param array $params tableau des valeurs enregistré en session cles => valeurs
     */
    public static function connect(array $params): void
    {
        $_SESSION = [self::$_NameSession => $params];
    }

    /**
     * $_NameSession nom de la session
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