<?php

namespace Cineflix\App\Model\DAO;

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
        $query = "SELECT s.id AS id, f.nom AS nom, f.cinopsys AS cinopsys, f.affiche AS affiche, 
                    f.date_sortie AS date_sortie, f.slug AS slug 
                    FROM streaming AS s 
                    JOIN fiche AS f ON s.fiche_id = f.id";

        $req = $this->db->prepare($query);

        return $req->fetchAll(StreamingModel::class);

    }
}