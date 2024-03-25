<?php

namespace Cineflix\App\Ajax;

use Cineflix\App\AppController;

class AjaxRequest
{

    /**
     * @return
     */
    static function cinemaSearch(string $value)
    {
        return $value;
    }

    static function filmSearch(string $value)
    {
        $fiche = new FicheDao();

        return $value;
    }
}