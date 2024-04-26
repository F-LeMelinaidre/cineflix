<?php

namespace Cineflix\App\DAO;

use Cineflix\App\AppController;
use Cineflix\App\DAO\List\StatusMovie;
use Cineflix\App\Model\MovieModel;

class MovieDao extends AbstractDAO
{

    protected array $relations = [
        'hasOne' => [
            'cinema' => 'movie.cinema_id = cinema.id'
        ]
    ];

    public function find(int $id, $options)
    {

        return parent::find($id, $options);
    }
    /**
     * @param string $status
     * @param array|null $options
     * @return array
     */
    public function findAllByStatus(string $status, array $options = null): array
    {
        $params = [
            'where' => ['col' => 'status',
                        'val' => StatusMovie::getStatus($status)],
            'hasOne' => ['cinema' => ['nom']]
        ];

        return $this->findAll($params);

        //return parent::findAllBy($params,$options);
    }

    /**
     * @param string $item
     * @param mixed $value
     * @return mixed|null
     */
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

    /**
     * @param MovieModel $movie
     * @return void
     */
    public function create(object $movie): void
    {

        var_dump($movie);
die();
    }
  
}