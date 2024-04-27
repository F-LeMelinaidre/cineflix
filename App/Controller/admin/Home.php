<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\App\Controller\Admin\Helper\sideMenu;
use Cineflix\Core\AbstractController;

class Home extends AbstractController
{

    protected string $layout = 'admin';

    public function index() {

        $menu ='Home index';

        return $this->render('Home.admin.index',compact('menu'));
    }
}