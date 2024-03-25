<?php

namespace Cineflix\App\Controller;

use Cineflix\App\Model\DAO\StreamingDao;
use Cineflix\Core\AbstractController;

class Streaming extends AbstractController
{


    public function index(): string
    {
        $streamingDao = new StreamingDao();
        $streaming = $streamingDao->findAll();

        return $this->render('Streaming.index',compact('streaming'));

    }

    public function show()
    {

    }

}
