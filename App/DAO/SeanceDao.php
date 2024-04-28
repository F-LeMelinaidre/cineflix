<?php

    namespace Cineflix\App\Dao;

    use Cineflix\App\AppController;
    use Cineflix\Core\Database\Database;

    class SeanceDao extends AbstractDAO
    {

        public function __construct() {
            $this->db = AppController::$_Database;
        }

        public function findAllFromMovie(int $id): array
        {
            $query = "SELECT * FROM seance
                      JOIN seance_film ON seance.id = seance_film.seance_id
                      WHERE seance_film.film_id = :id";
            $binvalue[] = ['col' => 'id', 'val' => $id];

            $req = $this->db->prepare($query, $binvalue);

            return $req->fetchall();

        }
    }