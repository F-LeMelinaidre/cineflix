<?php

namespace Cineflix\App\DAO;


use Cineflix\App\AppController;
use Cineflix\App\Model\StreamingModel;
use Cineflix\Core\Database\Database;

class StreamingDao
{
    private Database $db;

    public function __construct()
    {
        $this->db = AppController::$_Database;
    }

    public function findAll(): array
    {
        $query = "SELECT s.id AS id, f.nom AS nom, f.synopsis AS synopsis, f.affiche AS affiche, 
                    f.date_sortie AS date_sortie, f.slug AS slug 
                    FROM streaming AS s 
                    JOIN fiche AS f ON s.fiche_id = f.id";

        $req = $this->db->prepare($query);

        return $req->fetchAll(StreamingModel::class);

    }

    public function findBy(string $item, mixed $value)
    {
        $model = StreamingModel::class;
        switch($item) {
            case 'slug':
                $clause = 'slug LIKE :slug';
                break;
            case 'id':
            default:
                $item = 'id';
                $clause = 'id LIKE :id';
        }

        $query = "SELECT stream.id AS stream_id, fiche.id AS detail_id, fiche.nom AS nom, fiche.synopsis AS synopsis,
                  fiche.affiche AS affiche, fiche.date_sortie AS date_sortie, fiche.slug AS slug
                  FROM streaming AS stream JOIN fiche ON stream.fiche_id = fiche.id
                  WHERE fiche.$clause";

        $binvalue[] = ['col' => $item, 'val' => $value];
        $req = $this->db->prepare($query, $binvalue);

        return $req->fetch($model);

    }
  
}