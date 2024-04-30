<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\App\Controller\Admin\Helper\sideMenu;
use Cineflix\App\DAO\List\Role;
use Cineflix\Core\AbstractController;
use Cineflix\Core\Util\AuthConnect;

class Home extends AbstractController
{

    protected string $layout = 'admin';

    public function __construct()
    {
        parent::__construct();

        if(!AuthConnect::isConnected() || AuthConnect::getSession()['role'] < Role::ADMINISTRATEUR->value) {
            header('Location: /Signin');
            exit();
        }
    }

    public function index() {

        $menu ='Home index';

        return $this->render('Home.admin.index',compact('menu'));
    }
}