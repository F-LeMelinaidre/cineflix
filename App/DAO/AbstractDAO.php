<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\AppController;
    use Cineflix\Core\Database\Database;

    class AbstractDAO implements DAO
    {

        protected Database $db;
        protected string $table;
        protected string $model;
        protected int $last_id;

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

        /**
         * @return int
         */
        public function getLastId(): int
        {
            return $this->last_id;
        }

        /**
         * @param object $model
         *
         * @return void
         */
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
                ->where("$this->table.$col = :$col")
                ->setParameter($col,$val);

            if(isset($options['contain'])) {

                foreach ($options['contain'] as $relation => $condition) {
                    $req->join($relation, 'LEFT', $condition);

                }
            }

            return $req->fetch();

        }

        /**
         * @param array|null $options
         * @return mixed|null
         */
        public function findAll(array $options = null) {

            $select = $options['select'] ?? ['*'];

            $req = $this->db->select(...$select)
                ->from($this->table);

            if(isset($options['contain'])) {

                foreach ($options['contain'] as $relation => $condition) {
                    $req->join($relation, 'LEFT', $condition);
                }
            }

            if(isset($options['where'])) {
                $where  = $options['where'];
                $params = $options['params'];

                foreach ($where as $k => $condition) {
                    if($k === 0) {
                        $req->where($condition);
                    } else {
                        $req->andWhere($condition);
                    }
                }

                foreach ($params as $col => $val) {
                    $req->setParameter($col,$val);
                }

            }

            if(isset($options['order'])) {
                $req->order($options['order']);
            }

            return $req->fetchall();
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

                if(!is_null($value) && !is_object($value)) {
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
    }