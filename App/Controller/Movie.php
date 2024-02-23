<?php

namespace Cineflix\App\Controller;

use Cineflix\Core\AbstractController;

class Movie extends AbstractController
{

    public function __construct()
    {

        $this->title_page .= ' Films';

    }

    public function index()
    {

        $this->render('Movie.index',[]);

    }

    public function show()
    {

        $this->title_page .= ' | Titre du film';
        $this->render('Movie.show',[]);

    }
}
