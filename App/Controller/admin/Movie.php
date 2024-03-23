<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\App\AppController;
use Cineflix\App\Model\CinemaModel;
use Cineflix\App\Model\MovieModel;
use Cineflix\App\Model\VilleModel;
use Cineflix\Core\AbstractController;

class Movie extends AbstractController
{

    protected string $layout = 'admin';

    public function index(): string
    {
        $db = AppController::$_Database;
        $query = "SELECT * FROM film AS f JOIN fiche d ON f.fiche_id = d.id";
        $req = $db->prepare($query);
        $movies= $req->fetchAll(MovieModel::class);

        return $this->render('Movie.admin.index',compact("movies"));
    }

    public function show(int $id){}

    public function edit(int $id = null): string
    {
        $db = AppController::$_Database;

        $query = "SELECT c.id, c.ville_id, c.nom, v.id AS ville_id, v.nom AS ville  FROM cinema AS c JOIN ville AS v on c.ville_id = v.id ORDER BY v.nom";
        $req = $db->prepare($query);
        $cinemas = $req->fetchAll(CinemaModel::class);

        $query = "SELECT * FROM ville";
        $req = $db->prepare($query);
        $villes = $req->fetchall(VilleModel::class);

        if(!is_null($id)) {
            $query = "SELECT * FROM film AS f JOIN fiche d ON f.fiche_id = d.id WHERE f.id = :id";
            $binvalue[] = ['col' => 'id', 'val' => $id];
            $req = $db->prepare($query, $binvalue);
            $movie = $req->fetch(MovieModel::class);
        } else {
            $movie = new MovieModel();
        }
        if(!empty($_POST)) var_dump($_POST);
        $ville = 'Carnac';

        $title = (!isset($movie->id))? "Ajouter un film" : "Editer: ".ucwords($movie->nom);

        return $this->render('Movie.admin.edit',compact('title', 'movie', 'cinemas', 'villes', 'ville'));
    }

    public function delete()
    {

    }

    public function selectTown(int $id) {
        $db = AppController::$_Database;
        $query = "SELECT * FROM ville WHERE id = :id";
        $binvalue[] = ['col' => 'id', 'val' => $id];
        $req = $db->prepare($query, $binvalue);
        $ville = $req->fetch(VilleModel::class);
        return $ville->nom;
    }

}