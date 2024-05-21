<?php

    namespace Cineflix\App\DAO;

    interface DAO
    {

        public function create(object $model);

        public function findOneBy(string $col, string $val, array $options = []);

        public function update(object $data, string $id_column);

        public function delete();

    }