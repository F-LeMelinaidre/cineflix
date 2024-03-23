<?php

namespace Cineflix\App\Controller;

use Cineflix\App\Model\DAO\MovieDao;
use Cineflix\Core\AbstractController;

class Home extends AbstractController
{

    public function index(): string
    {
        $movieDao = new MovieDao();
        $movies = $movieDao->findAll();

        return $this->render('Home.index',compact('movies'));
    }
}
