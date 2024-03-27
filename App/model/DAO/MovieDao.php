<?php

namespace Cineflix\App\Model\DAO;

use Cineflix\App\AppController;
use Cineflix\App\Model\MovieModel;
use Cineflix\Core\Database\Database;

class MovieDao
{
    private Database $db;
    public function __construct() {
        $this->db = AppController::$_Database;
    }

    public function findAll(): array
    {
        $query = "SELECT f.id AS movie_id, d.id AS fiche_id, d.nom AS nom, d.synopsis AS synopsis,
                  d.affiche AS affiche, d.date_sortie AS date_sortie, d.slug AS slug, c.nom AS cinema,
                  v.nom AS ville
                  FROM film AS f JOIN fiche d ON f.fiche_id = d.id JOIN cinema c ON f.cinema_id = c.id JOIN ville v ON c.ville_id = v.id";

        $req = $this->db->prepare($query);
        $result = [];
        while ($row = $req->fetch()) {
            $result[] = new MovieModel(...$row);
        }
        var_dump($result);
        return [];

    }



    public function findBy(string $item, mixed $value, bool $model = true)
    {
        $model = (true === $model) ? MovieModel::class : $model;

        switch($item) {
            case 'slug':
                $clause = 'slug LIKE :slug';
                break;
            case 'id':
            default:
                $item = 'id';
                $clause = 'id LIKE :id';
        }

        $query = "SELECT f.id AS id, d.nom AS nom, d.synopsis AS synopsis,
                    d.affiche AS affiche, d.date_sortie AS date_sortie, d.slug AS slug, c.nom AS cinema,
                    v.nom AS ville
                    FROM film AS f JOIN fiche d ON f.fiche_id = d.id JOIN cinema c ON f.cinema_id = c.id JOIN ville v ON c.ville_id = v.id
                    WHERE d.$clause";

        $binvalue[] = ['col' => $item, 'val' => $value];
        $req = $this->db->prepare($query, $binvalue);

        return $req->fetch($model);

    }
  
    public function add(MovieModel $movie){

        var_dump($movie);



    }

    public function update(){}

    public function delete(){}
  
}