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
        $query = "SELECT film.id AS movie_id, fiche.id AS detail_id, fiche.nom AS nom, fiche.synopsis AS synopsis,
                  fiche.affiche AS affiche, fiche.date_sortie AS date_sortie, fiche.slug AS slug, cinema.nom AS cinema,
                  ville.nom AS ville
                  FROM film AS film JOIN fiche ON film.fiche_id = fiche.id JOIN cinema ON film.cinema_id = cinema.id JOIN ville ON cinema.ville_id = ville.id";

        $req = $this->db->prepare($query);

        return $req->fetchall(MovieModel::class);

    }



    public function findBy(string $item, mixed $value)
    {
        $model = MovieModel::class;

        switch($item) {
            case 'slug':
                $clause = 'slug LIKE :slug';
                break;
            case 'id':
            default:
                $item = 'id';
                $clause = 'id LIKE :id';
        }

        $query = "SELECT film.id AS movie_id, fiche.id AS detail_id, fiche.nom AS nom, fiche.synopsis AS synopsis,
                  fiche.affiche AS affiche, fiche.date_sortie AS date_sortie, fiche.slug AS slug, cinema.nom AS cinema,
                  ville.nom AS ville
                  FROM film AS film JOIN fiche ON film.fiche_id = fiche.id 
                  JOIN cinema ON film.cinema_id = cinema.id JOIN ville ON cinema.ville_id = ville.id
                  WHERE fiche.$clause";

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