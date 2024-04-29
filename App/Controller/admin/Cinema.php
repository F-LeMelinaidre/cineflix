<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\App\AppController;
use Cineflix\App\DAO\List\Role;
use Cineflix\App\Model\CinemaModel;
use Cineflix\Core\AbstractController;
use Cineflix\Core\Util\AuthConnect;

class Cinema extends AbstractController
{
    protected string $layout = 'admin';

    public function __construct()
    {
        parent::__construct();

        if(!AuthConnect::isConnected() || AuthConnect::getSession()['role'] < Role::SUPER_ADMINISTRATEUR->value) {
            header('Location: /');
            exit();
        }
    }

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