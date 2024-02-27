<?php

namespace Cineflix\App\Controller;

use Cineflix\Core\AbstractController;

class Home extends AbstractController
{

    public function index()
    {
        return $this->render('Streaming.index',[]);
    }
}
