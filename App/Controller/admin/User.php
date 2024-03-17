<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\Core\AbstractController;

class User extends AbstractController
{
    protected string $layout = 'admin';

    public function index(): string
    {
        return $this->render('user.admin.index',[]);
    }

    public function show(int $id): string
    {
        return $this->render('user.admin.show',[]);
    }

    public function edit(int $id = null): string
    {
        return $this->render('user.admin.edit',[]);
    }

    public function delete()
    {

    }

}