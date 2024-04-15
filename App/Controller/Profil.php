<?php

namespace Cineflix\App\Controller;

use Cineflix\Core\AbstractController;
use Cineflix\Core\Util\AuthConnect;

class Profil extends AbstractController
{

    public function __construct() {
        parent::__construct();
        if(!AuthConnect::isConnected()) {
            header('Location: /');
            exit();
        }
    }
    public function show()
    {
        $profil = [];
        return $this->render('profil.show',compact('profil'));
    }

    public function edit()
    {
        $profil = [];
        return $this->render('profil.edit',compact('profil'));
    }
}
