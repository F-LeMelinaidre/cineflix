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
        $query = "SELECT f.id AS id, d.nom AS nom, d.cinopsys AS cinopsys,
                  d.affiche AS affiche, d.date_sortie AS date_sortie, d.slug AS slug, c.nom AS cinema,
                  v.nom AS ville
                  FROM film AS f JOIN fiche d ON f.fiche_id = d.id JOIN cinema c ON f.cinema_id = c.id JOIN ville v ON c.ville_id = v.id";

        $req = $this->db->prepare($query);

        return $req->fetchAll(MovieModel::class);

    }

    public function findBy(string $item, mixed $value)
    {
        switch($item) {
            case 'slug':
                $clause = 'slug LIKE :slug';
                break;
            case 'id':
            default:
                $item = 'id';
                $clause = 'id LIKE :id';
        }

        $query = "SELECT f.id AS id, d.nom AS nom, d.cinopsys AS cinopsys,
                    d.affiche AS affiche, d.date_sortie AS date_sortie, d.slug AS slug, c.nom AS cinema,
                    v.nom AS ville
                    FROM film AS f JOIN fiche d ON f.fiche_id = d.id JOIN cinema c ON f.cinema_id = c.id JOIN ville v ON c.ville_id = v.id
                    WHERE f.$clause";

        $binvalue[] = ['col' => $item, 'val' => $value];
        $req = $this->db->prepare($query, $binvalue);

        return $req->fetch(MovieModel::class);

    }

}