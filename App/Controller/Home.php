<?php

namespace Cineflix\App\Controller;

use Cineflix\App\AppController;
use Cineflix\App\Model\MovieModel;
use Cineflix\Core\AbstractController;

class Home extends AbstractController
{

    public function index(): string
    {
        $db = AppController::$_Database;
        $query = "SELECT d.id AS id, d.nom AS nom, d.affiche AS affiche, d.slug AS slug, c.nom AS cinema, v.nom AS ville 
                    FROM film AS f
                    JOIN fiche d ON f.fiche_id = d.id
                    JOIN cinema c ON f.cinema_id = c.id
                    JOIN ville v ON c.ville_id = v.id ";

        $req = $db->prepare($query);
        $movies= $req->fetchAll(MovieModel::class);

        return $this->render('Home.index',compact('movies'));
    }
}
