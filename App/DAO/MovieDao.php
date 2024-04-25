<?php

namespace Cineflix\App\DAO;

use Cineflix\App\DAO\List\StatusMovie;
use Cineflix\App\Model\MovieModel;

class MovieDao extends AbstractDAO
{

    protected array $relations = [
        'hasOne' => [
            'cinema' => 'movie.cinema_id = cinema.id'
        ]
    ];

    public function findAll(array $options = null)
    {
        return parent::findAll($options);
    }

    public function findAllByStatus(string $status, array $options = null): array
    {

        $params = ['status' => StatusMovie::getStatus($status)];

        return parent::findAllBy($params,$options);
    }

    public function findAllMovie(): array
    {
        $query = "SELECT film.id AS movie_id, fiche.id AS detail_id, fiche.nom AS nom, fiche.synopsis AS synopsis,
                  fiche.affiche AS affiche, fiche.date_sortie AS date_sortie, fiche.slug AS slug, cinema.nom AS cinema,
                  ville.nom AS ville
                  FROM film AS film JOIN fiche ON film.fiche_id = fiche.id JOIN cinema ON film.cinema_id = cinema.id JOIN ville ON cinema.ville_id = ville.id";

        $req = $this->db->prepare($query);

        $result = $req->fetchall(MovieModel::class);


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

        $query = "SELECT *
                  FROM movie AS film 
                  WHERE film.$clause";

        $binvalue[] = ['col' => $item, 'val' => $value];
        $req = $this->db->prepare($query, $binvalue);

        return $req->fetch(MovieModel::class);

    }
  
    public function add(MovieModel $movie){

        var_dump($movie);



    }
  
}