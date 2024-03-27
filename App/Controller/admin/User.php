<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\Core\AbstractController;

class User extends AbstractController
{

    protected string $layout = 'admin';
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
