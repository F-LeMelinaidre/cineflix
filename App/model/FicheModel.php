<?php

namespace Cineflix\App\Model;

class FicheModel
{
  
    public $id;
    public string $nom;
    public string $synopsis;
    public string $affiche;
    public string $date_sortie;
    public string $date_sortie_fr;
    public string $slug;

    public function __construct($fiche_id, string $nom, string $synopsis, string $date_sortie, string $affiche, string $slug)
    {
        $this->nom = $nom;
        $this->synopsis = $affiche;
echo $date_sortie;
        $this->date_sortie = $date_sortie;
        $this->setDateFr($date_sortie);

        $this->affiche = $affiche;
        $this->slug = $slug;
    }

    private function setDateFr($timestamp)
    {
        $date = new \DateTime();
        $date->setTimestamp($timestamp);
        $this->date_sortie_fr =  $date->format('d/m/Y');
    }
}