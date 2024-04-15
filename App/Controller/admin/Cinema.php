<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\App\AppController;
use Cineflix\App\Model\CinemaModel;
use Cineflix\Core\AbstractController;

class Cinema extends AbstractController
{
    protected string $layout = 'admin';

    public function index(): string
    {
        $db = AppController::$_Database;
        $query = "SELECT c.id AS id, c.nom AS nom, c.ville_id AS ville_id, v.nom AS ville FROM cinema AS c JOIN ville v ON c.ville_id = v.id";
        $req = $db->prepare($query);
        $cinemas= $req->fetchAll(CinemaModel::class);

        return $this->render('cinema.admin.index',compact('cinemas'));
    }

    public function show(int $id): string
    {
        return $this->render('cinema.admin.show',[]);
    }

    public function edit(int $id = null): string
    {

        return $this->render('cinema.admin.edit',[]);
    }

    public function delete()
    {

    }



}