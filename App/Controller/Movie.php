<?php

namespace Cineflix\App\Controller;

use Cineflix\App\Model\DAO\MovieDao;
use Cineflix\Core\AbstractController;

class Movie extends AbstractController
{

    public function index(): string
    {
        $movieDao = new MovieDao();
        $movies = $movieDao->findAll();
        return $this->render('Movie.index',compact('movies'));

    }

    public function show(string $slug): string
    {
        $movieDao = new MovieDao();
        $movie = $movieDao->findBy('slug',$slug);

        if(!empty($movie)) {

            $this->title_page .= ' | '.ucfirst($movie->nom);
            return $this->render('Movie.show',compact('movie'));
        } else {
            return 'erreur';
        }

    }
}
