<?php

namespace Cineflix\App\Controller;

use Cineflix\Core\AbstractController;

class Auth extends AbstractController
{

    protected string $layout = 'auth';
    
    public function signin(): string
    {
        if(!empty($_POST)) {
            echo 'ok';
        }
        return $this->render('Auth.signin',[]);

    }

    public function signup(): string
    {

        return $this->render('Account.create',[]);

    }

    public function signout()
    {

    }
}
