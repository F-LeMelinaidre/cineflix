<?php

namespace Cineflix\App\Controller;

use Cineflix\App\DAO\List\StatusMovie;
use Cineflix\App\DAO\MovieDao;
use Cineflix\Core\AbstractController;

class Home extends AbstractController
{

    private $movieDao;

    public function __construct()
    {
        parent::__construct();

        $this->movieDao = new MovieDao();
    }

    public function index(?string $status = null): string
    {
        $status_id = (!is_null($status)) ? StatusMovie::getStatus($status) : StatusMovie::EN_SALLE->value;
        $buttons = [];

        $options = [
            'select'  => ['movie.*','cinema.nom','ville.nom AS cinema_ville_nom'],
            'where'  => ['status = :status'],
            'params' => ['status' => $status_id],
            'contain' => [
                'cinema' => 'cinema.id = movie.cinema_id',
                'ville'  => 'ville.id = cinema.ville_id'],
            'order'  => ['movie.modified']
        ];

        $movies = $this->movieDao->findAll($options);


        return $this->render('Home.index',compact('movies'));
    }
}
