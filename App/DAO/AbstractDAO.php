<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\AppController;
    use Cineflix\App\Model\MovieModel;
    use Cineflix\Core\Database\Database;

    class AbstractDAO implements DAO
    {

        private array $default_column = ['created', 'modified'];
        protected Database $db;
        protected string $table;
        protected array $relations;
        protected string $model;
        protected int $last_insert_id;



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
        public function findOneBy(array $params, array $options = null): mixed
        {
            if(!isset($options['select'])) {
                $columns = ['*'];
            } else {
                $columns = array_merge(['created','modified'], $options['select']);
            }

            $select = $this->setSelect($this->table, $columns);

            if(isset($options['hasOne'])) {
                $hasOne = $this->relations['hasOne'];

                foreach ($options['hasOne'] as $table => $opt) {
                    $join[] = "JOIN $table ON $hasOne[$table]";
                    $select .= ', '.$this->setSelect($table, $opt['select']);
                }
            }
            $join = (isset($join))? implode($join) : '';

            $where = [];
            $bindValues = [];
            foreach ($params as $key => $val) {
                $where [] = "$key = :$key";
                $bindValues[] = ['col' => "$key", 'val' => $val];
            }

            $where = implode(' AND ',$where);
            $query = "SELECT $select FROM $this->table $join WHERE $where";

            $req = $this->db->prepare($query, $bindValues);
            $result = $req->fetch();

            if(isset($options['hasOne'])) {
                $data = [];

                foreach ($result as $key => $val) {

                    $pos = strpos($key, '_');
                    if ($pos !== false) {

                        $prefix = substr($key, 0, $pos);

                        if (isset($hasOne[$prefix]) && $key !== $prefix . '_id') {

                            $unprefixed_kry = substr($key, $pos + 1);

                            $data[$prefix][$unprefixed_kry] = $val;

                            unset($result[$key]);
                        }
                    }
                }
                $result = array_merge($result, $data);
            }
            return $result;
        }

        public function findAll(array $options = null) {

            $sql = "SELECT * FROM $this->table";
            $req = $this->db->prepare($sql);
            return $req->fetchall($this->model);
        }
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
         * @param object $model
         * @param string $id_column
         *
         * @return Database
         */
        public function update(object $model, string $id_column = 'id'): Database
        {

            $sql = "UPDATE $this->table SET modified = CURRENT_TIMESTAMP";
            foreach ($model as $key => $val) {
                if(!is_object($val) && !empty($val)) {
                    $sql .= ", $key = :$key";
                    $bindValues[] = ['col' => $key, 'val' => $val];
                }
            }

            $sql .= " WHERE $id_column = :$id_column";
            $bindValues[] = ['col' => $id_column, 'val' => $model->getId()];
            return $this->db->prepare($sql, $bindValues);
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
         * @param string $alias
         * @param array  $columns
         *
         * @return string
         */
        protected function setSelect(string $alias, array $columns): string
        {
            $selectColumns = array_map(function($column) use ($alias) {
                return ($alias == $this->table || $column == '*')? "$alias.$column" : "$alias.$column AS ". $alias. "_" .$column;
            }, $columns);

            return implode(", ", $selectColumns);
        }
    }