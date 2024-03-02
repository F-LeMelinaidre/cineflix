<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\Core\AbstractController;

class Movie extends AbstractController
{

    protected string $layout = 'admin';

    public function index(): self
    {
        return $this->render('movie.admin.index',[]);
    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function delete()
    {

    }

}