<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\App\AppController;
use Cineflix\App\Model\CinemaModel;
use Cineflix\Core\AbstractController;

class Cinema extends AbstractController
{
    protected string $layout = 'admin';

    public function index(): string
    {

        $cinemas= [];

        return $this->render('cinema.admin.index',compact('cinemas'));
    }

    public function show(int $id): string
    {
        return $this->render('cinema.admin.show',[]);
    }

    public function edit(int $id = null): string
    {

        return $this->render('cinema.admin.edit',[]);
    }

    public function delete()
    {

    }



}