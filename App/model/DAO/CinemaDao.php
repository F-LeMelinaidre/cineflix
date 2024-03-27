<?php

namespace Cineflix\App\Model\DAO;

use Cineflix\Core\Database\Database;
use Cineflix\App\AppController;
use Cineflix\App\Model\CinemaModel;

class CinemaDao
{
    private Database $db;
    public function __construct() {
        $this->db = AppController::$_Database;
    }

    public function searchCinema($value)
    {
        $value = '%'. ltrim($value) .'%';

        $this->db = AppController::$_Database;
        $query = "SELECT cinema.id AS id, cinema.nom AS nom, cinema.ville_id AS ville_id, ville.id AS ville_id, ville.nom AS ville 
                FROM cinema
                INNER JOIN ville ON cinema.ville_id = ville.id
                WHERE cinema.nom LIKE :nom_cinema OR ville.nom LIKE :nom_ville";

        $binvalue[] = ['col' => 'nom_cinema', 'val' => $value];
        $binvalue[] = ['col' => 'nom_ville', 'val' => $value];
        $req = $this->db->prepare($query, $binvalue);

        return $req->fetchAll(CinemaModel::class);

    }

}