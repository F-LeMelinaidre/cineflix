<?php

namespace Cineflix\Core\Database;

use Cineflix\Core\Util\MessageFlash;
use Exception;
use PDO;
///
class Database
{
    public static $_Instance;

    private PDO $connexion;
    private $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    public function __construct(string $root)
    {
        $settings = require $root . "/Core/Database/config.php";

        $dsn = 'mysql:host=' . $settings['db_host'] . ';port=' . $settings['db_port'] . ';dbname=' . $settings['db_name'];

        $this->getPDO($dsn, $settings['db_user'], $settings['db_pwd']);
    }

    public static function getInstance(string $root)
    {
        if(!self::$_Instance) {
            self::$_Instance = new Database($root);
        }
        return self::$_Instance;
    }

    private function getPDO($dsn, $db_user, $db_pwd)
    {
        try {

            $this->connexion = new PDO($dsn, $db_user, $db_pwd, $this->options);
        } catch (Exception $e) {
            MessageFlash::create("Exception capturée: Connexion au SGBDR impossible! <br>" . $e->getMessage(), 'erreur');
            header('Location: erreur/500');
        }
    }

    public function prepare($query, $bindvalues)
    {
        try {

            $pre = $this->connexion->prepare($query);

            if (!is_null($bindvalues)) {

                foreach ($bindvalues as $val) {
                    $pre->bindValue($val['col'], $val['val'], PDO::PARAM_STR);
                }
            }

            $pre->execute();

            return $pre;
        } catch (Exception $e) {

            MessageFlash::create("Impossible de récupérer les données sur la table! <br>" . $e->getMessage(), 'erreur');
            return false;
        }
    }
}
