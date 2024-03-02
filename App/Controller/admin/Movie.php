<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\Core\AbstractController;

class Movie extends AbstractController
{

    protected string $layout = 'admin';

    public function index(): string
    {
        return $this->render('Movie.admin.index',[]);
    }

    public function show(int $id): string
    {
        return $this->render('Movie.admin.show',[]);
    }

    public function edit(int $id = null): string
    {
        return $this->render('Movie.admin.edit',[]);
    }

    public function delete()
    {

    }

}