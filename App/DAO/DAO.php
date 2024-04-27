<?php

    namespace Cineflix\App\DAO;

    interface DAO
    {

        public function create(object $model);

        public function findOneBy(string $col, string $val, array $options = null);

        public function update(object $model);

        public function delete();

    }