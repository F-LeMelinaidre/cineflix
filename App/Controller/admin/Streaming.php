<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\Core\AbstractController;

class Streaming extends AbstractController
{
    protected string $layout = 'admin';

    public function index(): string
    {
        return $this->render('streaming.admin.index',[]);
    }

    public function show(int $id): string
    {
        return $this->render('streaming.admin.show',[]);
    }

    public function edit(int $id = null): string
    {
        return $this->render('streaming.admin.edit',[]);
    }

    public function delete()
    {

    }

}