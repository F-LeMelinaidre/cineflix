<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\AppController;
    use Cineflix\Core\Database\Database;

    class AbstractDAO implements DAO
    {

        protected Database $db;

        public function __construct()
        {
            $this->db = AppController::$_Database;
        }
        public function create(object $model) {}

        public function read() {}

        public function update() {}

        public function delete() {}

        public function getLastInsert()
        {
            // TODO: Implement getLastInsert() method.
        }
    }