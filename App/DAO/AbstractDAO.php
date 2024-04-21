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
        protected array $foreign_keys;
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

        public function findOneBy(array $params, array $options = null) {

            $select = '*';

            if(isset($options['select'])) {

                $select = $this->setSelect($this->table,$options['select']);

            }

            if(isset($options['contains'])) {
                foreach ($options['contains'] as $key => $column) {

                    $select .= ', ' .$this->setSelect($key,$column);
                    $join[] = "JOIN $key ON {$this->foreign_keys[$key]}";

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

            $this->query = "SELECT $select FROM $this->table $join WHERE $where";

            $req = $this->db->prepare($this->query, $bindValues);


            if(!isset($options['contains'])) {

                $result = $req->fetch($this->model);

            } else {

                $result = $req->fetch();
                foreach ($result as $key => $val) {

                    $pos = strpos($key, '_');

                    if ($pos !== false) {

                        $prefix = substr($key, 0, $pos);
                        $column = substr($key, $pos + 1);

                        $result[$prefix][$column] = $val;

                        unset($result[$key]);
                    }
                }

            }

            return $result;

        }

        public function update() {}

        public function delete() {}

        protected function setLastInsertId() {
            $this->last_insert_id = $this->db->getLastInsertId();
        }
        public function getLastInsertId()
        {
            return (isset($this->last_insert_id))? $this->last_insert_id : null;
        }

        protected function setSelect(string $alias, array $columns): string
        {
            $selectColumns = array_map(function($column) use ($alias) {

                return ($alias == $this->table)? "$alias.$column" : "$alias.$column AS ". $alias. "_" .$column;
            }, $columns);

            return implode(", ", $selectColumns);
        }
    }