<?php

namespace Cineflix\Core\Database;

use Exception;
use PDO;

class Database
{
    public static $_Instance;

    private PDO $connexion;
    private $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    private $request;

    /**
     * @param string $root
     */
    public function __construct(string $root)
    {
        $settings = require $root . "/Core/Database/config.php";

        $dsn = 'mysql:host=' . $settings['db_host'] . ';port=' . $settings['db_port'] . ';dbname=' . $settings['db_name'];

        $this->getPDO($dsn, $settings['db_user'], $settings['db_pwd']);
    }

    /**
     * @param string $root
     *
     * @return Database
     */
    public static function getInstance(string $root): self
    {
        if(!self::$_Instance) {
            self::$_Instance = new Database($root);
        }
        return self::$_Instance;
    }

    /**
     * @param string $dsn
     * @param string $db_user
     * @param string $db_pwd
     *
     * @return void
     */
    private function getPDO(string $dsn, string $db_user, string $db_pwd): void
    {
        try {

            $this->connexion = new PDO($dsn, $db_user, $db_pwd, $this->options);
        } catch (Exception $e) {
            echo 'erreur getPDO()';
            //MessageFlash::create("Exception capturée: Connexion au SGBDR impossible! <br>" . $e->getMessage(), 'erreur');
            //header('Location: erreur/500');
        }
    }

    /**
     * @param string $query
     * @param array  $bindvalues
     *
     * @return Database
     */
    public function prepare(string $query, array $bindvalues = [])
    {
        try {
            $this->request = $this->connexion->prepare($query);

            if (!empty($bindvalues)) {

                foreach ($bindvalues as $val) {
                    $this->request->bindValue(':'.$val['col'], $val['val'], PDO::PARAM_STR);
                }

            }

            $this->request->execute();

            return $this;
        } catch (Exception $e) {
            echo 'erreur prepare() '.$e->getMessage();
            //MessageFlash::create("Impossible de récupérer les données sur la table! <br>" . $e->getMessage(), 'erreur');
            return null;
        }
    }

    /**
     * @param string|null $class_name
     *
     * @return mixed
     */
    public function fetch(string $class_name = null)
    {
        $mode = (is_null($class_name))? [PDO::FETCH_ASSOC] : [PDO::FETCH_CLASS, $class_name];

        try {
            $this->request->setFetchMode(...$mode);

            return $this->request->fetch();
        } catch (Exception $e) {
            echo 'erreur fetch() '.$e->getMessage();
            //MessageFlash::create("Impossible de récupérer les données sur la table! <br>" . $e->getMessage(), 'erreur');
            return null;
        }
    }

    /**
     * @param string|null $class_name
     *
     * @return mixed
     */
    public function fetchall(string $class_name = null)
    {
        $mode = (is_null($class_name))? [PDO::FETCH_ASSOC] : [PDO::FETCH_CLASS, $class_name];
        $this->request->setFetchMode(...$mode);
        $data = $this->request->fetchAll();
        return $data;
    }

    public function count()
    {
        return $this->request->fetchColumn();
    }

    /**
     * @param string $sql
     * @param array  $bindValues
     *
     * @return bool
     */
    public function insert(string $sql, array $bindValues): bool
    {
        try {
            $pre = $this->connexion->prepare($sql);

            foreach ($bindValues as $val) {
                $pre->bindValue(':'.$val['col'], $val['val']);
            }

        return $pre->execute();

        } catch (Exception $e) {
            echo 'erreur insert() '.$e->getMessage();
            return false;
        }
    }
}
