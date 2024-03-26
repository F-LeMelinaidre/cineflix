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
        $result = false;

        $value = $_POST['nom'];
        $ficheDao = new FicheDao();
        $fiche = $ficheDao->findBy('nom', $value);
        $timeToDate = strtotime($fiche->date_sortie);
        $fiche->date_sortie = date("Y-m-d", $timeToDate);
        if(!empty($fiche)) $result = json_encode($fiche);

        echo $result;
    }
}