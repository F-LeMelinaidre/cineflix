<?php

namespace Cineflix\App\Controller;

use Cineflix\App\AppController;
use Cineflix\Core\AbstractController;
use PDO;

class Home extends AbstractController
{

    public function index()
    {
        $db = AppController::$_Database;
        $query = "SELECT * FROM fiche WHERE date_sortie > :date_sortie";
        $binvalue[] = ['col' => 'date_sortie', 'val' => '1999-09-21 22:00:00'];
        $req = $db->prepare($query, $binvalue);
        $data= $req->fetchAll(PDO::FETCH_ASSOC);

        var_dump($data);
        return $this->render('Streaming.index',[]);
    }
}
