<?php

namespace Cineflix\App\Controller;

use Cineflix\Core\AbstractController;

class Auth extends AbstractController
{

    protected string $layout = 'auth';
    
    public function signin()
    {

        return $this->render('Auth.signin',[]);

    }

    public function signup()
    {

        return $this->render('Account.create',[]);

    }

    public function signout()
    {

    }
}
