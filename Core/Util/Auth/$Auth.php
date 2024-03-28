<?php

    namespace Cineflix\Core\Util\Auth;
//TODO COPIE COLLE DU PROJET MVC A MODIFIER ET METTRE DANS LE CONTROLLER
use Cineflix\Core\Util\SqlDao;

class Auth
    {
        private static $_table;
        private static $_model;

        private static $_connect = false;
        private static $_name_session;

        /**
         * @param string $table
         * @param string $name_session
         */
        public static function init($table = 'user', $name_session = 'Auth')
        {
            self::$_table = $table;
            self::$_model = 'App\Model\\'.ucfirst(self::$_table).'Model';

            self::$_name_session = $name_session;

            if (isset($_SESSION[self::$_name_session]))
                self::$_connect = true;
        }

        /**
         * @uses self::getInstance()
         * @param string $col colonne de reference  $colonne = email , $valeur = mon-email@mail.mvc
         * @param string $value valeur de la colonne
         * @param string $pwd mot de passe
         * @return bool
         */

        /**
         * @param string $col Colonne de la table
         * @param string $val Valeur de la colonne
         * @param string $pwd Mot de passe
         */
        public static function logon(string $col, string $value, string $pwd): bool
        {
            $db = new SqlDao();


            $request = $db->select('password')
                ->from('user')
                ->where($col . ' LIKE :' . $col)
                ->setBindValues([$col => $value]);

            $user = $request->getOne(self::$_model);
            echo $user->password;
            if ($user) {

                if (password_verify($pwd, $user->password))
                    self::$_connect = true;

            }

            return self::$_connect;
        }

        /**
         * @param string $name_session nom de la session
         * @param array $params tableau des valeurs enregistré en session cles => valeurs
         */
        public static function connect(array $params): void
        {
            $_SESSION = [self::$_name_session => $params];
        }

        /**
         * @param string $name_session nom de la session
         */
        public static function deconnect(): void
        {
            self::$_connect = false;
            unset($_SESSION[self::$_name_session]);
        }

        public static function isConnected(): bool
        {
            return self::$_connect;
        }

        public static function getNameSession(): string {
            return self::$_name_session;
        }
    }