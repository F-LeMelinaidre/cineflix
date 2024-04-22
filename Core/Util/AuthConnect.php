<?php

namespace Cineflix\Core\Util;

use Cineflix\Core\Database\Database;

/**
 *  5BVMeCVmcdGy!?2pd
 *  La table utilisateur doit avoir au minimum les colonnes suivantes :
 *  id | (identifiant) | password | token | created | modified | time_connect | last_time_connect
 *
 *  Le nom de la colonne pour l'identifiant est defini lors de l'appel de la methode logon()
 *
 */
class AuthConnect
{

    private static $_Database;
    private static $_Table;
    private static $_Connect = false;
    private static $_NameSession;

    private static $_IdColonne;
    private static $_Token;

    /**
     * @param Database $database Instance de Database
     * @param String $name_session Nom de Session
     *
     * @return void
     */
    public static function init($database, $table, $id_colonne = 'username', $name_session = 'Auth')
    {
        self::$_Database = $database;
        self::$_Table = $table;
        self::$_IdColonne = $id_colonne;

        self::$_NameSession = $name_session;

        if (isset($_SESSION[self::$_NameSession]))
            self::$_Connect = true;
    }

    /**
     * @param string $col_name Colonne de la table
     * @param string $value Valeur de la colonne
     * @param string $pwd Mot de passe
     */
    public static function verify(string $id_value, string $pwd): bool
    {

        $table = self::$_Table;
        $id_colonne = self::$_IdColonne;

        $query ="SELECT $id_colonne, password FROM $table WHERE $id_colonne = :$id_colonne";
        $bindValues[] = ['col' => $id_colonne, 'val' => $id_value];

        $req = self::$_Database->prepare($query, $bindValues);

        $result = $req->fetch();

        return $result && password_verify($pwd, $result['password']);
    }

    /**
     * $_NameSession nom de la session
     * @param array $params tableau des valeurs enregistré en session cles => valeurs
     */
    public static function connect(string $id_value, array $params = null): bool
    {
        $table = self::$_Table;
        $id_colonne = self::$_IdColonne;


        $sql = "SELECT last_connect FROM $table WHERE $id_colonne = :$id_colonne";
        $bindValues = [
            ['col' => $id_colonne, 'val' => $id_value]
        ];
        $req = self::$_Database->prepare($sql, $bindValues);
        $result = $req->fetch();

        $params_default = [
            'token'         => self::getToken(),
            'last_connect'  => date("d-m-Y H:i:s", strtotime($result['last_connect']))
        ];

        $params = array_merge($params, $params_default);

        $update = "UPDATE $table SET last_connect = connect, connect = :connect, token = :token WHERE $id_colonne = :$id_colonne";
        $bindValues = [
            ['col' => $id_colonne, 'val' => $id_value],
            ['col' => 'token', 'val' => self::$_Token],
            ['col' => 'connect', 'val' => date("Y-m-d H:i:s")]
        ];

        if(!is_null(self::$_Database->prepare($update, $bindValues))) {
            self::$_Connect = true;
            $_SESSION = [self::$_NameSession => $params];
        }

        return self::$_Connect;
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

    public static function getSession(): array
    {
        return $_SESSION[self::$_NameSession];
    }

    private static function setToken(): void
    {
        $randomBytes = random_bytes(16);
        self::$_Token = bin2hex($randomBytes);
    }

    public static function getToken(): string
    {
        if(!isset(self::$_Token)) self::setToken();

        return self::$_Token;
    }
}