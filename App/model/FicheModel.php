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


    //TODO
    private function setSlug(){}

    private function setDateFr($timestamp)
    {
        $date = new \DateTime();
        $date->setTimestamp($timestamp);
        $this->date_sortie_fr =  $date->format('d/m/Y');
    }
}
