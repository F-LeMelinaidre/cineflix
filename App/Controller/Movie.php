<?php

namespace Cineflix\App\Controller;

use Cineflix\App\Model\DAO\MovieDao;
use Cineflix\App\AppController;
use Cineflix\App\Model\MovieModel;

use Cineflix\Core\AbstractController;

class Movie extends AbstractController
{

    public function index(): string
    {
        $movieDao = new MovieDao();
        $movies = $movieDao->findAll();
        return $this->render('Movie.index',compact('movies'));

    }

    public function show(string $slug, int $id): string
    {
        $movieDao = new MovieDao();
        $movie = $movieDao->findBy('slug',$slug);

        $req = $db->prepare($query, $binvalue);
        $movie = $req->fetch(MovieModel::class);

        if(!empty($movie)) {

            $this->title_page .= ' | '.ucfirst($movie->nom);
            return $this->render('Movie.show',compact('movie'));
        } else {
            return 'erreur';
        }

    }
}
