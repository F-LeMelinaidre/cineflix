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
        private array $table_join;
        private array $alias = [];
        private array $where = [];
        private array $order = [];
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
         * mettre un alias des lors que l'on fait une requete avec jointure table.colonne
         *
         * la methode getSelect() ajoute par defaut AS "table_colonne" pour les
         * jointures de premier niveau
         * si la table liée est elle même jointe de nouveau, ajouter manuellement le AS dans le select
         * exemple AS cinema_ville_"nom de la colonne"
         *
         * @return self
         */
        public function select(string ...$selects): self
        {
            $this->select = $selects;

            return $this;
        }

        /**
         * Créé la partie Select de la requete à partir du tableau $select
         * @return string
         */
        private function getSelect(): string
        {
            if(!empty($this->join)) {

                foreach($this->select as $k => $select) {

                    // recupère l'alias de la colonne
                    $parts = explode('.', $select);
                    $alias = $parts[0];
                    $column = $parts[1];

                    // si l'alias récupéré est différent du nom de la table,
                    // on renomme la référence de la colonne
                    if($alias !== $this->table && $column !== '*' && !strpos($column, "AS")) {
                        $select = $select.' AS '.$alias.'_'.$column;
                    }

                    $this->select[$k] = $this->convertToAliasColumn($select);
                }
            }
            return implode(', ',$this->select);
        }

        /**
         * @param string $table
         *
         * @return $this
         */
        public function from(string $table): self
        {
            // créé l'alias et l'ajoute au tableau $alias
            $this->setAlias($table);

            $this->table = $table;

            return $this;
        }

        /**
         * @return string
         */
        private function getFrom(): string
        {
            // si une jointure est effectué on parametre le FROM avec l'alias stocké dans $alias
            return (!empty($this->join))? $this->table.' AS '.$this->alias[$this->table] : $this->table;
        }

        /**
         * @param string $table
         * Créé les alias avec la preimer lettre de la table par defaut
         * Dans le cas où lors de la création de la jointure,
         * la table commence par la meme lettre qu'une précédante jointure
         * present dans le tableau $alias, on boucle et ajoute la second lettre
         * de la table, ainsi de suite, jusqu'a se que l'alias soit unique
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
        }

        /**
         * @param string $string
         * Convertie le nom de la colonne defini lors de la creation de la requete (user.nom)
         * le prefix qui correspond au nom de la table,
         * est remplacé par l'alias stocké dans le tableau $alias indexé par le nom de la table
         *
         * exemple: user.name
         * si l'alias stocker dans $alias à l'index user = u ,
         * la colonne à selectionné sera renommé u.nom
         *
         * @return string
         */
        private function convertToAliasColumn(string $string): string
        {
            $parts = explode('.', $string);

            $alias = $this->alias[$parts[0]];
            $col = $parts[1];

            return "$alias.$col";
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
        private function getWhere(): string{
            return implode(' ',$this->where);
        }

        /**
         * @param string $column
         * @param string $order
         *
         * @return $this
         */
        public function order(array $orders, string $direction = 'DESC'): self
        {

            foreach ($orders as $order) {
                $column = $this->convertToAliasColumn($order);
                $this->order[] = "$column $direction";
            }
            return $this;
        }

        /**
         * @return string
         */
        private function getOrder(): string
        {
            $order = "ORDER BY ".implode(' AND ', $this->order);
            return !empty($this->order)? $order : '';
        }

        /**
         * Créé la jointure
         * @param string $table
         * @param string $alias
         * @param string $condition
         * @return $this
         */
        public function join(string $table, string $type, string $condition): self
        {
            $this->setAlias($table);

            $condition = $this->formatJoinCondition($condition);

            array_push($this->join, "$type JOIN $table AS ".$this->alias[$table]." ON $condition");

            return $this;
        }

        /**
         * Converti la condition de jointure en remplaçant le prefix representant le nom de la table
         * par l'alias stocké dans le tableau $alias et indéxé par le nom de la table
         *
         * @param string $condition
         *
         * @return string
         */
        private function formatJoinCondition(string $condition): string
        {
            $parts = explode('=', $condition);

            $table_col = $this->convertToAliasColumn(trim($parts[0]));
            $join_col = $this->convertToAliasColumn(trim($parts[1]));;

            return "$table_col = $join_col";
        }

        /**
         * Assemble l'ensemble des jointures stockées de le tableau $join
         * @return string
         */
        private function getJoin(): string{
            return implode(' ', $this->join);
        }

        //TODO Pour les requetes complexe
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
         * Créé la requete sql
         * @return string|null
         */
        private function queryBuilder()
        {
            try {

                if(count($this->where) != count($this->bind_values))
                    throw new Exception("paramètre manquant");

                $select = $this->getSelect();
                $table = $this->getFrom();
                $join = $this->getJoin();
                $where = $this->getWhere();
                $order = $this->getOrder();
                //TODO Order

                return "SELECT $select FROM $table $join $where $order";

            } catch (Exception $e) {
                echo 'Erreur buildQuery(): '.$e->getMessage();
                return null;
            }
        }

        /**
         * @param string $query
         * @param array  $bindvalues
         *
         * @return Database
         */
        private function prepare()
        {
          
            try {

                $this->request = $this->connexion->prepare($this->sql);

                if (!empty($this->bind_values)) {

                    foreach ($this->bind_values as $val) {
                        $this->request->bindValue(':'.$val['col'], $val['val'], PDO::PARAM_STR);
                    }
                }

                $this->where = [];
                $this->join = [];
                $this->bind_values = [];

                return $this;

            } catch (Exception $e) {
                echo 'erreur prepare() '.$e->getMessage();
                return null;
            }
        }

        public function execute(): self
        {
            $set = implode(', ', $this->set);
            $where = implode(' ',$this->where);

            $this->sql .= "$set $where";

            //echo __CLASS__.' | '.__FUNCTION__.'<br>';
            //$this->debug();
            //die();

            $this->prepare();

            $this->request->execute();

            return $this;
        }
        /**
         * @param string|null $class_name
         *
         * @return mixed
         */
        public function fetch(mixed $class = null)
        {

            $mode = (is_null($class))? [PDO::FETCH_ASSOC] : [PDO::FETCH_CLASS, $class];

            try {

                $this->sql = $this->queryBuilder();

                //echo __CLASS__.' | '.__FUNCTION__.'<br>';
                //$this->debug();
                //die();

                $this->prepare();

                $this->request->execute();

                $this->request->setFetchMode(...$mode);

                $this->resetProperties();

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

                $this->sql = $this->queryBuilder();

                //echo __CLASS__.' | '.__FUNCTION__.'<br>';
                //$this->debug();
                //die();

                $this->prepare();

                $this->request->execute();

                $this->request->setFetchMode(...$mode);

                $this->resetProperties();

                return $this->request->fetchAll();

            }catch (Exception $e) {
                echo 'erreur fetchAll() '.$e->getMessage();
                //MessageFlash::create("Impossible de récupérer les données sur la table! <br>" . $e->getMessage(), 'erreur');
                return null;
            }
        }

        /**
         * @return null
         */
        public function count()
        {
            try {

                $this->prepare();
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
        public function getLastInsertId()
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

        private function resetProperties(): void
        {
            $this->select = [];
            $this->sql = '';
            $this->table = '';
            $this->alias = [];
            $this->where = [];
            $this->join = [];
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
            echo 'Requete final:<br>';
            echo $this->sql.'<br>';
        }
    }