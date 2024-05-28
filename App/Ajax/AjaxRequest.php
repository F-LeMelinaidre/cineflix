<?php

    namespace Cineflix\App\Ajax;

    use Cineflix\App\DAO\FilmDao;
    use Cineflix\App\Model\DAO\CinemaDao;
    use Cineflix\App\Model\DAO\FicheDao;

    class AjaxRequest
    {
        static function filmSearch()
        {

            $value = $_POST['nom'];
            $ficheDao = new FilmDao();
            $fiche = $ficheDao->searchFilmByName($value);


            echo json_encode($fiche);
        }

    }