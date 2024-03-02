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

    public function show(int $id): string
    {
        return $this->render('Movie.admin.show',[]);
    }

    public function edit(int $id = null): string
    {
        return $this->render('Movie.admin.edit',[]);
    }

    public function delete()
    {

    }

}