<?php

namespace Cineflix\App\Controller;

use Cineflix\App\DAO\StreamingDao;
use Cineflix\Core\AbstractController;
use Cineflix\Core\Util\AuthConnect;

class Streaming extends AbstractController
{

    public function __construct()
    {
        parent::__construct();
        if(!AuthConnect::isConnected()) {
            header('Location: /');
            exit();
        }
    }

    public function index(): string
    {
        $streamingDao = new StreamingDao();
        $streams = $streamingDao->findAll();

        return $this->render('Streaming.index',compact('streams'));

    }

    public function show(string $slug)
    {
        $streamDao = new StreamingDao();
        $stream = $streamDao->findBy('slug', $slug);
        $this->title_page .= ' | ' . ucfirst($stream->nom);


        return $this->render('Streaming.show', compact('stream'));
    }

}
