<?php

namespace Cineflix\App\Controller;

use Cineflix\App\AppController;
use Cineflix\App\Model\FicheModel;
use Cineflix\Core\AbstractController;

class Movie extends AbstractController
{

    public function index(): string
    {

        return $this->render('Movie.index',[]);

    }

    public function show(string $slug, int $id): string
    {
        $db = AppController::$_Database;
        $query = "SELECT * FROM fiche WHERE id = :id AND slug = :slug";

        $binvalue = [
            ['col' => 'id', 'val' => $id],
            ['col' => 'slug', 'val' => $slug]
        ];

        $req = $db->prepare($query, $binvalue);
        $movie = $req->fetch(FicheModel::class);
        if(!empty($movie)) {

            $this->title_page .= ' | '.ucfirst($movie->nom);
            return $this->render('Movie.show',compact('movie'));
        } else {
            return 'erreur';
        }

    }
}
