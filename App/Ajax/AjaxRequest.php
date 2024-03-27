<?php

namespace Cineflix\App\Ajax;

use Cineflix\App\AppController;
use Cineflix\App\Model\DAO\CinemaDao;
use Cineflix\App\Model\DAO\FicheDao;

class AjaxRequest
{
    static function filmSearch()
    {

        $value = $_POST['nom'];
        $ficheDao = new FicheDao();
        $fiche = $ficheDao->searchFilmByName($value);


        echo json_encode($fiche);
    }

    static function cinemaSearch()
    {
        $value = $_POST['cinema'];
        $cinemaDao = new CinemaDao();
        $cinemas = $cinemaDao->searchCinema($value);

        echo json_encode($cinemas);
    }
}