<?php

namespace Cineflix\App\Model;

class MovieModel extends FicheModel
{
    public int $id;

    public string $nom = '';
    public string $cinopsys = '';

    public string $affiche = '';

    public string $date_sortie = '';
    public string $cinema = '';
    public string $ville = '';

}