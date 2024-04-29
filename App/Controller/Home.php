<?php

namespace Cineflix\App\Controller;

use Cineflix\App\DAO\List\StatusMovie;
use Cineflix\App\DAO\MovieDao;
use Cineflix\Core\AbstractController;

class Home extends AbstractController
{

    private $movieDao;

    public function index(?string $status = null): string
    {
        $status_id = (!is_null($status)) ? StatusMovie::getStatus($status) : StatusMovie::EN_SALLE->value;

        $options = [
            'select'  => ['movie.*','cinema.nom','ville.nom'],
            'contain' => [
                'cinema' => 'cinema.id = movie.cinema_id',
                'ville'  => 'ville.id = cinema.ville_id'],
            'order'  => ['movie.modified']
        ];
        $options['where']  = ['status = :status'];
        $options['params'] = ['status' => $status_id];

        $this->movieDao = new MovieDao();
        $movies = $this->movieDao->findAll($options);

        return $this->render('Home.index',compact('movies'));
    }
}
