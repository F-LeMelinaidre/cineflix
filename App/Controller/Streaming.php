<?php

namespace Cineflix\App\Controller;

use Cineflix\Core\AbstractController;

class Streaming extends AbstractController
{


    public function index(): string
    {

        return $this->render('Streaming.index',[]);

    }

    public function show()
    {

    }

}
