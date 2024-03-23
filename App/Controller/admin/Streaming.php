<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\App\AppController;
use Cineflix\App\Model\StreamingModel;
use Cineflix\Core\AbstractController;

class Streaming extends AbstractController
{
    protected string $layout = 'admin';

    public function index(): string
    {
        $db = AppController::$_Database;
        $query = "SELECT * FROM streaming AS s JOIN fiche d ON s.fiche_id = d.id";
        $req = $db->prepare($query);
        $movies= $req->fetchAll(StreamingModel::class);

        return $this->render('streaming.admin.index',compact("movies"));
    }

    public function show(int $id){}

    public function edit(int $id = null): string
    {
        $db = AppController::$_Database;

        if(!is_null($id)) {
            $query = "SELECT * FROM streaming AS s JOIN fiche d ON s.fiche_id = d.id WHERE d.id = :id";
            $binvalue[] = ['col' => 'id', 'val' => $id];
            $req = $db->prepare($query, $binvalue);
            $movie = $req->fetch(StreamingModel::class);
        } else {
            $movie = new StreamingModel();
        }
        $title = (!isset($movie->id))? "Ajouter un stream" : "Editer: ".ucwords($movie->nom);

        return $this->render('streaming.admin.edit',compact('title', 'movie'));
    }

    public function delete()
    {

    }

}