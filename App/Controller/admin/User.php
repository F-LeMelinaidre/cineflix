<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\App\DAO\List\Role;
use Cineflix\Core\AbstractController;
use Cineflix\Core\Util\AuthConnect;

class User extends AbstractController
{

    protected string $layout = 'admin';

    public function __construct()
    {
        parent::__construct();

        if(!AuthConnect::isConnected() || AuthConnect::getSession()['role'] < Role::SUPER_ADMINISTRATEUR) {
            header('Location: /Signin');
            exit();
        }
    }

    public function index()
    {
        $users = [];
        return $this->render('User.admin.index',compact("users"));
    }

    public function show()
    {
        echo 'Function: '.__FUNCTION__.'<br>Line: '.__LINE__.'<br><br>';

    }

    public function edit()
    {
        echo 'Function: '.__FUNCTION__.'<br>Line: '.__LINE__.'<br><br>';

    }

}
