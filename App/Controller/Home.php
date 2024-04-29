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
        $status_id = (!is_null($status)) ? StatusMovie::getStatus($status) : null;
        $buttons = [];

        if($status_id !== StatusMovie::EN_SALLE->value || !is_null($status_id)){
            $id = StatusMovie::EN_SALLE->value;
            $buttons[StatusMovie::EN_SALLE->value] = self::$_Router->getUrl('admin_movie_add', [ 'status' => StatusMovie::getUrl($id) ]);
        }
        if($status_id !== StatusMovie::EN_STREAMING->value || !is_null($status_id)) {
            $id = StatusMovie::EN_STREAMING->value;
            $buttons[StatusMovie::EN_STREAMING->value] = self::$_Router->getUrl('admin_movie_add',['status' => StatusMovie::getUrl($id)]);
        }

        $options = [
            'select'  => ['movie.*','cinema.nom','ville.nom'],
            'contain' => [
                'cinema' => 'cinema.id = movie.cinema_id',
                'ville'  => 'ville.id = cinema.ville_id'],
            'order'  => ['movie.modified']
        ];

        if(!is_null($status)) {
            $options['where']  = ['status = :status'];
            $options['params'] = ['status' => $status];
        }
        $this->movieDao = new MovieDao();
        $movies = $this->movieDao->findAll($options);


        return $this->render('Home.index',compact('movies'));
    }
}
