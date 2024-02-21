<?php

namespace Cineflix\App\Controller;

use Cineflix\Core\AbstractController;

class AuthController extends AbstractController
{

    public function __construct()
    {
        echo '<br>Class: '.__CLASS__.'<br>';
        
    }

    public function signin()
    {
        echo 'Function: '.__FUNCTION__.'<br>Line: '.__LINE__.'<br><br>';
    }

    public function signout()
    {
        echo 'Function: '.__FUNCTION__.'<br>Line: '.__LINE__.'<br><br>';

    }

    public function logout()
    {
        echo 'Function: '.__FUNCTION__.'<br>Line: '.__LINE__.'<br><br>';

    }
}
