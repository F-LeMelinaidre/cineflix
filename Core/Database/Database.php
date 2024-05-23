<?php

    namespace Cineflix\Core\Database;

    use Exception;
    use PDO;
    use PhpParser\Node\Scalar\String_;

    class Database
    {

        private string $sql;
        private array $select = [];
        private array $set = [];
        private string $table;
        private array $alias = [];
        private array $where = [];
        private string $order = '';
        private array $join = [];
        private array $bind_values = [];
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
         * @return self
         */
        public function select(string ...$selects): self
        {
            $this->select = $selects;
            return $this;
        }

        /**
         * @return string
         */
        private function getSelect(): string
        {
            return !empty($this->join) ? $this->updateSelect($this->select) : implode(', ',$this->select);
        }

        // construit le select en fonction des colonnes prefixé par leur table lors de jointure table.colonne => t.colonne
        // Lors de chaque iteration de $selects on index par le nom de colonne $prev_colonne et attribut la valeur true
        // Lors des iterations on la renomme la colonne AS table_colonne
        // $this->select stock tous les colonnes indexé par leur table si jointure
        // Ce tableau est utilisé pour mapper le resultat
        // - les colonnes des tables jointes sont réorganisé en sous tableau indexé par le nom de la table d'origine et
        //   on leur réattribu leur nom de colonne d'origine
        /**
         * @param $columns
         *
         * @return string
         */
        private function updateSelect($columns): string
        {
            $sql = [];
            $tables = array_flip($this->alias);
            foreach ($columns as &$column) {

                $parts = explode('.',$column);

                if (in_array($parts[0],$tables)) {
                    $tbl = $parts[0];
                    $col = $parts[1];

                } else {
                    $tbl = $this->table;
                    $col = $column;
                }
                $column = $this->alias[$tbl].'.'.$col;

                if($col !== '*' && $tbl !== $this->table) $column .= " AS ".$tbl."_".$col;


            }

            return implode(', ', $columns);
        }

        /**
         * @param string $table
         *
         * @return $this
         */
        public function from(string $table): self
        {
            $this->setAlias($table);
            $this->table = $table;

            return $this;
        }

        /**
         * @return string
         */
        private function getTable(): string
        {
            $tbl = $this->table;

            if (!empty($this->join)) $tbl .= " AS ".$this->alias[$tbl];

            return $tbl;
        }

        /**
         * Créé la jointure
         *
         * @param string $table
         * @param string $condition
         * @param string $alias
         *
         * @return $this
         */
        public function join(string $join, string $condition, string $type = 'INNER'): self
        {
            $this->setAlias($join);

            $parts = explode('=', $condition);
            $a = $this->aliasColumn(trim($parts[0]), 'Join');
            $b = $this->aliasColumn(trim($parts[1]), 'Join');

            array_push($this->join, "$type JOIN $join AS ".$this->alias[$join]." ON $a = $b");

            return $this;
        }

        /**
         * @return string
         */
        private function getJoin(): string
        {
            return isset($this->join) ? implode(' ', $this->join) : '';
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
            $this->where[] = "OR $condition";

            return $this;
        }

        /**
         * @param string $condition
         *
         * @return $this
         */
        public function andWhere(string $condition): self
        {
            $this->where[] = "AND $condition";

            return $this;
        }

        /**
         * Assemble l'ensemble de condition where stocké dans le tableau $where
         * @return string
         */
        private function getWhere(): string
        {
            $where = !empty($this->join)? $this->formatWhere($this->where) : implode(' ',$this->where);
            return $where;
        }

        /**
         * @param array $conditions
         *
         * @return string
         */
        private function formatWhere(array $conditions): string
        {

            foreach ($conditions as &$condition) {

                $parts = explode(' ',$condition);
                $pre = trim($parts[0]);

                $col = trim($parts[1]);
                $col = $this->aliasColumn($col, "Condition $pre");

                $operator = trim($parts[2]);
                $param = trim($parts[3]);

                $condition = "$pre $col $operator $param";
            }
            return implode(' ',$conditions);
        }

        /**
         * @param string $column
         * @param string $order
         *
         * @return $this
         */
        public function order(string $order, string $direction = 'DESC'): self
        {
            $order = !empty($this->join) ? $this->aliasColumn($order, 'Order') : $order;

            $this->order = "ORDER BY $order $direction";

            return $this;
        }

        /**
         * @param string $table
         * Créé l'e 'Alias avec la premiere lettre de la table
         * Lors de création de jointure si la table commence par la meme lettre
         * qu'une précédante jointure stocké dans $this->alias,
         * on boucle et ajoute la seconde lettre de la table,
         * ainsi de suite, jusqu'a se que l'Alias soit unique
         * @return void
         */
        private function setAlias(string $table): void
        {
            $i = 1;
            $alias = substr($table, 0, 1);

            while (in_array($alias,$this->alias)) {

                ++$i;
                $alias = substr($table, 0, $i);
            }

            $this->alias[$table] = $alias;
            $i = 0;
        }

        /**
         * @param string $col
         *
         * @return string
         */
        private function aliasColumn(string $col, string $method_name): string
        {
            try {

                $parts = explode('.',$col);

                if(isset($parts[1])) {
                    $tbl = $parts[0];
                    $col = $parts[1];
                    $alias = $this->alias[$tbl];

                    $col = $alias.'.'.$col;


                } else {
                    throw new Exception("La colonne $parts[0] n'est pas préfixé du nom de sa table !!!");
                }

            } catch (Exception $e) {
                echo "$method_name aliasColumn() : " . $e->getMessage();
            }
            return $col;
        }

        //TODO Pour les requetes complexe
        /**
         * @param string $sql
         *
         * @return $this
         */
        public function createCustomQuery(string $sql): self
        {
            $this->sql = $sql;
            return $this;
        }

        /**
         * Prépare le tableau pour les valeurs à passer à la methode bindValue()
         * pour la requete préparé
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
            return $this;
        }

        /**
         * @return string
         */
        private function buildQuery(): string
        {
            $select = $this->getSelect();
            $table = $this->getTable();
            $join = $this->getJoin();
            $where = $this->getWhere();
            $order = $this->order;

            return "SELECT $select FROM $table $join $where $order";
        }

        /**
         * @param string $query
         * @param array  $bindvalues
         *
         * @return Database
         */
        private function prepare($sql)
        {

            try {

                $this->request = $this->connexion->prepare($sql);
                if (!empty($this->bind_values)) {

                    foreach ($this->bind_values as $val) {
                        $this->request->bindValue(':'.$val['col'], $val['val'], PDO::PARAM_STR);
                    }
                }

                $this->bind_values = [];
                return $this;

            } catch (Exception $e) {
                echo 'erreur prepare() '.$e->getMessage();
                return null;
            }

        }

        /**
         * @return $this
         */
        public function execute(): self
        {
            $set = implode(', ', $this->set);
            $where = implode(' ',$this->where);

            $this->sql .= "$set $where";
            //echo __CLASS__.' | '.__FUNCTION__.'<br>';
            //$this->debug();
            //die();

            $this->prepare($this->sql);

            $this->request->execute();

            return $this;
        }

        /**
         * @param string|null $class_name
         *
         * @return mixed
         */
        public function fetch()
        {

            try {

                //echo __CLASS__.' | '.__FUNCTION__.'<br>';
                //$this->debug();
                //die();
                $sql =  $this->buildQuery();
                $this->prepare($sql);

                $this->request->setFetchMode(PDO::FETCH_ASSOC);

                $this->request->execute();

                $res = $this->request->fetch();

                if($res && isset($this->join)) $res = $this->mapping($res);

                $this->resetProperties();

                return $res? $res : [];

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
        public function fetchAll()
        {

            try {
                $this->sql =  $this->buildQuery();
                $this->prepare($this->sql);

                //echo __CLASS__.' | '.__FUNCTION__.'<br>';
                //$this->debug();
                $this->request->execute();

                $this->request->setFetchMode(PDO::FETCH_ASSOC);

                $res = $this->request->fetchAll();

                $res = isset($this->join)? $this->mapResults($res) : $res;
                $this->resetProperties();
                return $res;

            } catch (Exception $e) {
                echo 'erreur fetchAll() '.$e->getMessage();
                //MessageFlash::create("Impossible de récupérer les données sur la table! <br>" . $e->getMessage(), 'erreur');
                return null;
            }
        }

        /**
         * @param array $result
         *
         * @return array
         */
        private function mapResults(array $result): array
        {
            foreach($result as &$row) {

                $row = $this->mapping($row);

            }
            return $result;
        }

        private function mapping(array $data): array
        {
            $tables = array_flip($this->alias);
            foreach($data as $id => $val) {

                $parts = explode("_",$id);
                if (in_array($parts[0],$tables)) {
                    $tbl = $parts[0];
                    $col = $parts[1];

                    if(!isset($data[$tbl])) $data[$tbl] = [];

                    if(!empty($val)) $data[$tbl][$col] = $val;
                    unset($data[$id]);
                }
            }

            return $data;
        }
        /**
         * @return null
         */
        public function count()
        {
            try {

                $this->prepare($this->sql);
                $this->request->execute();

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


        /**
         * @param string $table
         *
         * @return void
         */
        public function createUpdate(string $table): self
        {
            $this->table = $table;
            $this->sql = "UPDATE $this->table SET ";

            return $this;
        }

        /**
         * @param string $col
         * @param string $val
         *
         * @return void
         */
        public function set(string $col, string $val): self
        {
            $this->set[] = "$col = $val";
            return $this;
        }

        /**
         * @return false|string
         */
        public function getLastInsertId(): int
        {
            return $this->connexion->lastInsertId();
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
         * @return void
         */
        private function resetProperties(): void
        {
            $this->set = [];
            $this->alias = [];
            $this->join = [];
            $this->where = [];
            $this->bind_values = [];
        }

        public function debug(): void
        {
            echo 'DEBUG<br>';
            if(!empty($this->select)) {
                echo 'Array SELECT:<br>';
                var_dump($this->select);
            }

            echo "Table: $this->table <br>";

            if(!empty($this->set)) {
                echo 'Array SET:<br>';
                var_dump($this->set);
            }

            if(!empty($this->join)) {
                echo 'Array JOIN:<br>';
                var_dump($this->join);
            }

            if(!empty($this->alias)) {
                echo 'Array Alias:<br>';
                var_dump($this->alias);
            }

            if(!empty($this->where)) {
                echo 'Array WHERE:<br>';
                var_dump($this->where);
            }

            if(!empty($this->bind_values)) {
                echo 'BindValues:<br>';
                var_dump($this->bind_values);
            }

            if(!empty($this->sql)) {
                echo 'Requete final:<br>';
                echo $this->sql.'<br>';
            }
        }
    }