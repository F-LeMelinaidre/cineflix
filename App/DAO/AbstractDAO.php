<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\AppController;
    use Cineflix\Core\Database\Database;

    class AbstractDAO implements DAO
    {

        private array $data = [];
        protected array $result = [];

        protected Database $db;
        protected string $table;
        protected string $model;
        protected string $created;
        protected string $modified;

        protected string $path_model = "\\Cineflix\\App\\Model\\";
        protected int $last_id;

        /**
         *
         */
        public function __construct()
        {
            $this->db = AppController::$_Database;

            $class_name = basename(get_called_class());
            $this->table = str_replace('dao', '', strtolower($class_name));
            $this->model = $this->path_model.ucfirst($this->table).'Model';

            $this->created = date("Y-m-d H:i:s");
            $this->modified = date("Y-m-d H:i:s");

        }

        /**
         * @return int
         */
        public function getLastId(): int
        {
            return $this->last_id;
        }

        public function getDataUpdated(): array
        {
            return $this->data;
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
        public function findOneBy(string $col, string $val, array $options = []): array
        {   //TODO à completer (Where, Order etc...)

            $select = $options['select'] ?? ['*'];
            $req = $this->db->select(...$select)
                ->from($this->table)
                ->where("$this->table.$col = :$col")
                ->setParameter($col,$val);

            if(isset($options['where'])) {

                foreach($options['where'] as $where) {
                    $req->andWhere($where);
                }

                foreach ($options['params'] as $col => $val) {
                    $req->setParameter($col, $val);
                }

            }

            if(isset($options['contain'])) {

                foreach ($options['contain'] as $relation => $condition) {
                    $req->join($relation, $condition, 'LEFT');

                }
            }

            $result = $req->fetch();

            return $result;

        }

        /**
         * @param array|null $params
         *
         * @return mixed|null
         */
        public function findAll(array $params = []): array
        {
            $table = $params['table'] ?? $this->table;
            $select = $params['select'] ?? [ '*'];

            $req = $this->db->select(...$select)
                ->from($table);


            if (isset($params['contain'])) {

                foreach ($params['contain'] as $relation => $condition) {
                    $req->join($relation, $condition, 'LEFT');
                }
            }

            if (isset($params['where'])) {
                $where  = $params['where'];
                $set_param = $params['params'];

                foreach ($where as $k => $condition) {
                    if($k === 0) {
                        $req->where($condition);
                    } else {
                        $req->andWhere($condition);
                    }
                }

                foreach ($set_param as $col => $val) {
                    $req->setParameter($col,$val);
                }

            }


            if (isset($params['order'])) {
                $req->order($params['order']);
            }


            return $req->fetchAll();
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
        public function update($data, string $id_column = 'id' ): Database
        {

            $req = $this->db->createUpdate($this->table);

            $id = $data['id'];
            unset($data['id']);

            foreach ($data as $item => $value) {

                $req->set($item, ':'.$item)
                    ->setParameter($item, $value);
            }

            $req->set('modified', ':modified')
                ->setParameter('modified', $this->modified);

            $this->data = $data;

            return $req->where("$id_column = :$id_column")
                ->setParameter($id_column, $id)
                ->update();

        }


        /**
         * @return void
         */
        public function delete() {}


        public function mapToModel(): array
        {
            foreach($this->result as $k => $data) {
                $this->result[$k] = new $this->model($data);
            }

            return $this->result;
        }

        private function mapToJson(array $result): string
        {
            return json_encode($this->result, JSON_PRETTY_PRINT);
        }
    }