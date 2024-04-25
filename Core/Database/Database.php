<?php

    namespace Cineflix\Core\Database;

    use Exception;
    use PDO;

    class Database
    {

        private string $select;
        private string $table;
        private array $where = [];
        private array $join = [];
        private array $bind_values;
        private $request;

        public static $_Instance;

        public PDO $connexion;
        private $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];


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
         * @param string ...$selects
         *
         * @return self
         */
        public function select(string ...$selects): self
        {

            foreach($selects as $k => $val) {
                $selects[$k]= (strlen($val) == 1)? "$val.*" : $val;
            }

            $this->select = implode(', ', $selects);
            return $this;
        }

        /**
         * @param string $table
         *
         * @return $this
         */
        public function from(string $table, string $alias = null): self
        {
            $this->table = (isset($alias))? "$table AS $alias" : $table;
            return $this;
        }

        /**
         * @param string $condition
         *
         * @return $this
         */
        public function where(string $condition): self
        {
            $this->where[] = "WHERE $condition";

            return $this;
        }

        /**
         * @param string $condition
         *
         * @return $this
         */
        public function orWhere(string $condition): self
        {
            $this->where[] = " OR $condition";

            return $this;
        }

        /**
         * @param string $condition
         *
         * @return $this
         */
        public function andWhere(string $condition): self
        {
            $this->where[] = " AND $condition";

            return $this;
        }
        /**
         * @param string $col
         * @param string $val
         *
         * @return $this
         */
        public function setParameter(string $col, string $val): self
        {
            $this->bind_values[] = [
                'col' => $col,
                'val' => $val
            ];

            if(empty($this->where)) $this->where[] = "WHERE $col = :$col";

            return $this;
        }

        public function leftJoin(string $table, string $alias, string $condition): self
        {
            $this->join[] = "LEFT JOIN $table AS $alias ON $condition";
            return $this;
        }

        public function returnQuery()
        {
            echo (count($this->where) + count($this->join)). ' - ' .count($this->bind_values);
            if((count($this->where) + count($this->join)) != count($this->bind_values)) echo 'parametre manquant';
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
