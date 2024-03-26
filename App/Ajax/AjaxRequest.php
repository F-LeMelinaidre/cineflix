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
        $data = false;

        $value = $_POST['nom'];
        $ficheDao = new FicheDao();
        $fiche = $ficheDao->ajaxFilm('nom', $value);

        //if(!empty($fiche)) {
        //    $timeToDate = strtotime($fiche->date_sortie);
        //    $fiche->date_sortie = date("Y-m-d", $timeToDate);
            $data = json_encode($fiche);
        //}

        echo $data;
    }
}