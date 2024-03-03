<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\App\AppController;
use Cineflix\App\model\table\MovieTable;
use Cineflix\Core\AbstractController;

class Movie extends AbstractController
{

    protected string $layout = 'admin';

    public function index(): string
    {
        $db = AppController::$_Database;
        $query = "SELECT * FROM film AS f JOIN fiche d ON f.fiche_id = d.id";
        $req = $db->prepare($query);
        $movies= $req->fetchAll(MovieTable::class);

        return $this->render('Movie.admin.index',compact("movies"));
    }

    public function edit(int $id = null): string
    {

        if(!is_null($id)) {
            $db = AppController::$_Database;
            $query = "SELECT * FROM film AS f JOIN fiche d ON f.fiche_id = d.id WHERE f.id = :id";
            $binvalue[] = ['col' => 'id', 'val' => $id];
            $req = $db->prepare($query, $binvalue);
            $movie = $req->fetch(MovieTable::class);
        } else {
            $movie = new MovieTable();
        }


        $title = (!isset($movie->id))? "Ajouter un film" : "Editer: ".ucwords($movie->nom);

        return $this->render('Movie.admin.edit',compact('title', 'movie'));
    }

    public function delete()
    {

    }

}