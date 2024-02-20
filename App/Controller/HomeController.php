<?php

namespace Cineflix\App\Controller;

class HomeController
{
    public function __construct()
    {
        echo '<br>Class: '.__CLASS__.'<br>';

    }

    public function index()
    {
        echo 'Function: '.__FUNCTION__.'<br>Line: '.__LINE__.'<br><br>';

    }
}
