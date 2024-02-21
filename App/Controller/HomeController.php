<?php

namespace Cineflix\App\Controller;

use Cineflix\Core\AbstractController;

class HomeController extends AbstractController
{
    public function __construct()
    {

    }

    public function index()
    {

        $this->render('Streaming.index',[]);

    }
}
