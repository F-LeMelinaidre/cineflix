<?php

namespace Cineflix\App\Controller;

use Cineflix\Core\AbstractController;

class Auth extends AbstractController
{

    public function __construct()
    {
        $this->header = false;
    }

    public function signin()
    {

        $this->render('Auth.signin',[]);

    }

    public function signout()
    {

        $this->render('Account.create',[]);

    }

    public function logout()
    {

    }
}
