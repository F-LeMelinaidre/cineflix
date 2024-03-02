<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\Core\AbstractController;

class Cinema extends AbstractController
{
    protected string $layout = 'admin';

    public function index(): string
    {
        return $this->render('cinema.admin.index',[]);
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