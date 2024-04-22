<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\AppController;
    use Cineflix\Core\Database\Database;

    class AbstractDAO implements DAO
    {

        protected Database $db;
        protected string $req;
        protected string $query;

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
        public function findOneBy(array $params, array $options = null): array
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
                    $join[] = "JOIN $table ON {$hasOne[$table]}";
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

        /**
         * @param object $model
         *
         * @return void
         */
        public function update(object $model) {}

        /**
         * @return void
         */
        public function delete() {}

        /**
         * @return void
         */
        protected function setLastInsertId() {
            $this->last_insert_id = $this->db->getLastInsertId();
        }

        /**
         * @return int|null
         */
        public function getLastInsertId()
        {
            return (isset($this->last_insert_id))? $this->last_insert_id : null;
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