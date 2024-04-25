<?php

    namespace Cineflix\Core\Database;

    use Exception;
    use PDO;

    class Database
    {
        public static $_Instance;

        public PDO $connexion;
        private $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        private string $select = '*';
        private string $table;
        private string $where = '';
        private array $bind_values;
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
         * Debut de transaction
         * @return void
         */
        public function beginTransaction()
        {
            $this->connexion->beginTransaction();
        }


        /**
         * Validation de la transaction
         * @return void
         */
        public function commit()
        {
            $this->connexion->commit();
        }

        /**
         * En cas d'erreur, annule la transaction
         * @return void
         */
        public function rollback()
        {
            $this->connexion->rollBack();
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
         * @param array $data
         *
         * @return $this
         */
        public function setBindValues(array $data) {

            foreach ($data as $col => $val) {
                $this->bind_values[] = ['col' => $col,'val' => $val];
            }

            return $this;
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

            try {
                $this->request->setFetchMode(...$mode);
                $data = $this->request->fetchAll();

                return $data;

            }catch (Exception $e) {
                echo 'erreur fetch() '.$e->getMessage();
                //MessageFlash::create("Impossible de récupérer les données sur la table! <br>" . $e->getMessage(), 'erreur');
                return null;
            }
        }

        public function count()
        {
            try {

                return $this->request->fetchColumn();

            }catch (Exception $e) {
                echo 'erreur fetch() '.$e->getMessage();
                //MessageFlash::create("Impossible de récupérer les données sur la table! <br>" . $e->getMessage(), 'erreur');
                return null;
            }
        }

        /**
         * @param string $sql
         * @param array  $bindValues
         *
         * @return bool
         */
        public function insert(string $table, array $data): bool
        {
            $result = false;

            try {

                $columns = implode(', ', array_keys($data));
                $values = implode(', :', array_keys($data));
                $values = ":$values";


                $sql = "INSERT INTO $table ($columns) VALUE ($values)";


                $pre = $this->connexion->prepare($sql);


                foreach ($data as $key => $val) {
                    $pre->bindValue(':'.$key, $val);
                }

                $result = $pre->execute();

            } catch (\PDOException $e) {

                $result = false;

                throw $e;
            }

            return $result;
        }

        public function getLastInsertId()
        {
            return $this->connexion->lastInsertId();
        }
    }
