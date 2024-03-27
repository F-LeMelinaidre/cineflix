<?php

namespace Cineflix\App\Model;

class MovieModel extends FicheModel
{

    private int $fiche_id;
    private int $cinema_id;
    private int $exploitation_id;
    public string $exploitation_debut = '';
    public string $exploitation_fin = '';

    public function __construct(int $fiche_id, string $nom, string $synopsis, string $date_sortie, string $affiche, string $slug, int $movie_id,  $cinema, $ville)
    {
        parent::__construct($fiche_id, $nom, $synopsis, $date_sortie, $affiche, $slug);
        $this->nom = $nom;

    }

}