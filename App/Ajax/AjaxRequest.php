<?php

namespace Cineflix\App\Ajax;

use Cineflix\App\AppController;
use Cineflix\App\Model\DAO\FicheDao;

class AjaxRequest
{

    /**
     * @return
     */
    static function cinemaSearch(string $value)
    {
        return $value;
    }

    static function filmSearch()
    {

        $value = $_POST['nom'];
        $ficheDao = new FicheDao();
        $fiche = $ficheDao->ajaxFilm('nom', $value);


        echo json_encode($fiche);
    }
}