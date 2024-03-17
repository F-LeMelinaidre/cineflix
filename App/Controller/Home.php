<?php

namespace Cineflix\App\Controller;

use Cineflix\App\AppController;
use Cineflix\App\model\table\FicheTable;
use Cineflix\Core\AbstractController;

class Home extends AbstractController
{

    public function index(): string
    {
        $db = AppController::$_Database;
        $query = "SELECT * FROM fiche WHERE date_sortie > :date_sortie";
        $binvalue[] = ['col' => 'date_sortie', 'val' => '1999-09-21 22:00:00'];
        $req = $db->prepare($query, $binvalue);
        $movies= $req->fetchAll(FicheTable::class);

        return $this->render('Home.index',compact('movies'));
    }
}
