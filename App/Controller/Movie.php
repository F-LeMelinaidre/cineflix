<?php

namespace Cineflix\App\Controller;

use Cineflix\App\Model\DAO\MovieDao;
use Cineflix\App\Model\MovieModel;
use Cineflix\Core\AbstractController;

class Movie extends AbstractController
{

    protected array $movies;
    public function index(): string
    {
        $movieDao = new MovieDao();
        $this->movies = $movieDao->findAll();


        return $this->render('Movie.index',['movies' => $this->movies]);

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
