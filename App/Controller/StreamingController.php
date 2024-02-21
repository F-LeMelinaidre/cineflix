<?php

namespace Cineflix\App\Controller;

use Cineflix\Core\AbstractController;

class StreamingController extends AbstractController
{

    public function __construct()
    {

        $this->title_page .= ' Streaming';

    }

    public function index()
    {

        $this->render('Streaming.index',[]);

    }

    public function show()
    {

    }

}
