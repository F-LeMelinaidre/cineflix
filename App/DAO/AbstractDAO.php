<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\AppController;
    use Cineflix\Core\Database\Database;

    class AbstractDAO implements DAO
    {

        private array $default_column = ['created', 'modified'];
        protected Database $db;
        protected string $table;
        protected array $relations;
        protected string $model;
        protected int $last_insert_id;

        /**
         *
         */
        public function __construct()
        {
            $this->db = AppController::$_Database;

            $class_name = basename(get_called_class());
            $this->table = str_replace('dao', '', strtolower($class_name));
            $this->model = "\\Cineflix\\App\\Model\\".ucfirst($this->table).'Model';

        }
        public function create(object $model) {}

        /**
         * @param array      $params
         * @param array|null $options
         *
         * @return array
         */
        public function findOneBy(string $col, string $val, array $options = null): mixed
        {   //TODO à completer (Where, Order etc...)


            $select = $options['select'] ?? ['*'];
            $req = $this->db->select(...$select)
                ->from($this->table)
                ->where("$col = :$col")
                ->setParameter($col,$val);

            if(isset($options['contain'])) {
                $hasOne = $options['contain'];
                foreach ($hasOne as $relation) {
                    $req->join($relation, 'LEFT', $this->relations['hasOne'][$relation]);

                }
            }

            //if(isset($options['hasOne']))
            //    $this->buildJoin($req, $options);

            $result = $req->fetch();


            //if(isset($options['hasOne']))
            //    $result = $this->mapResult($result, $options);

            if(isset($options['contain'])) {
                $result = $this->mapResult($result, $options['contain']);
            }

            return $result;

        }

        /**
         * @param array|null $options
         * @return mixed|null
         */
        public function findAll(array $options = null) {
            //TODO gerer les options

            $alias = substr($this->table, 0, 1);
            $req = $this->db->select($alias)
                ->from($this->table);

            if(isset($options['where'])) {
                $where = $options['where']['col'].' = :'.$options['where']['col'];
                $req->where($where)
                    ->setParameter($options['where']['col'],$options['where']['val']);
            }

            return $req->fetchall($this->model);
        }

        /**
         * @param array $params
         * @param array|null $options
         * @return mixed
         */
        public function findAllBy(array $params, array $options = null): mixed
        {
            $where = [];
            $bindValues = [];
            foreach ($params as $key => $val) {
                $where [] = "$key = :$key";
                $bindValues[] = ['col' => "$key", 'val' => $val];
            }

            $where = implode(' AND ',$where);

            $sql = "SELECT * FROM $this->table WHERE $where";
            $req = $this->db->prepare($sql, $bindValues);
            return $req->fetchall($this->model);
        }

        /**
         * @param string $col
         * @param string $val
         *
         * @return null
         */
        public function isExist(string $col, string $val)
        {
            $sql = "SELECT EXISTS ( SELECT $col FROM $this->table WHERE $col LIKE :$col )";
            $req =$this->db->createCustomQuery($sql)
                ->setParameter($col, $val);

            return $req->count();
        }

        /**
         * @param object $model
         * @param string $id_column
         *
         * @return Database
         */
        public function update(object $model, string $id_column = 'id'): Database
        {
            $req = $this->db->createUpdate($this->table);
            foreach($model as $item => $value) {
                echo $item;
                if(!is_null($value)) {
                    $req->set($item, ':'.$item)
                        ->setParameter($item, $value);
                }
            }
            $req->set('modified', ':modified')
                ->setParameter('modified', date("Y-m-d H:i:s"));

            return $req->where("$id_column = :$id_column")
                ->setParameter($id_column, $model->getId())
                ->execute();
        }

        /**
         * @return void
         */
        public function delete() {}

        /**
         * @return void
         */
        protected function setLastInsertId(): void
        {
            $this->last_insert_id = $this->db->getLastInsertId();
        }

        /**
         * @return int
         */
        public function getLastInsertId(): int
        {
            return (isset($this->last_insert_id))? $this->last_insert_id : $this->db->getLastInsertId();
        }

        /**
         * @param array $data
         * @param array $relations
         *
         * @return array
         */
        private function mapResult(array $data, array $relations): array
        {
            foreach($relations as $table) {
                // place toutes les colonnes de la relation hasOne dans un sous tableau de $resultat
                // et supprime toutes les paires cle => valeur des clés prefixé par le nom de la table lié
                if(isset($this->relations['hasOne']) && array_key_exists($table,$this->relations['hasOne'])) {

                    $data[$table] = [];
                    foreach ($data as $key => $value) {
                        if (strpos($key, $table . '_') === 0 && !isset($data[$table . '_id'])) {
                            $unprefixed_key = substr($key, strlen($table) + 1);
                            $data[$table][$unprefixed_key] = $value;
                            unset($data[$key]);
                        }
                    }
                }

            }

            return $data;
        }
    }