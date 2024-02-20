<?php

namespace Cineflix\App\Controller;

class MovieController
{

    public function __construct()
    {
        echo '<br>Class: '.__CLASS__.'<br>';

    }

    public function index()
    {
        echo 'Function: '.__FUNCTION__.'<br>Line: '.__LINE__.'<br><br>';

    }

    public function show()
    {
        echo 'Function: '.__FUNCTION__.'<br>Line: '.__LINE__.'<br><br>';

    }
}
