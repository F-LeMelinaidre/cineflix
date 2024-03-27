<?php

namespace Cineflix\App\Model;

class MovieModel extends DetailModel
{

    public $movie_id;
    public $cinema;
    public $ville;
    public int $fiche_id;
    public int $cinema_id;
    public int $exploitation_id;
    public string $exploitation_debut = '';
    public string $exploitation_fin = '';



}
