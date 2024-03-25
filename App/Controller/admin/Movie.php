<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\App\Model\DAO\MovieDao;
use Cineflix\App\Model\MovieModel;
use Cineflix\Core\AbstractController;

class Movie extends AbstractController
{

    protected string $layout = 'admin';

    public function index(): string
    {

        $movieDao = new MovieDao();
        $movies = $movieDao->findAll();
        return $this->render('Movie.admin.index',compact("movies"));
    }

    public function show(int $id){}

    public function edit(int $id = null): string
    {

        if(!is_null($id)) {

            $movieDao = new MovieDao();
            $movie = $movieDao->findBy('id', $id);

        } else {

            $movie = new MovieModel();

        }

        if(!empty($_POST)) var_dump($_POST);

        $title = (!isset($movie->id))? "Ajouter un film" : "Editer: ".ucwords($movie->nom);

        return $this->render('Movie.admin.edit',compact('title', 'movie'));
    }

    public function delete()
    {

    }

}