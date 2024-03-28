<?php

namespace Cineflix\App\Model;

abstract class DetailModel
{
  
    public int $detail_id;
    public string $nom = '';
    public string $synopsis = '';
    public string $date_sortie = '';
    public string $affiche = '';
    public string $date_sortie_fr = '';
    public string $slug = '';


    public function __construct()
    {
        //$this->setDateFr($this->date_sortie);
    }
    //TODO
    private function setSlug(){}

    private function setDateFr($date)
    {
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);  // Convert datetime to DateTime object
        $this->date_sortie_fr = $date->format('d - m - Y');
    }
}