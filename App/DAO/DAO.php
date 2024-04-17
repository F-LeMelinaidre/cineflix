<?php

    namespace Cineflix\App\DAO;

    interface DAO
    {

        public function create(object $model);

        public function read();

        public function update();

        public function delete();

        public function getLastInsert();

    }