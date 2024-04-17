<?php

namespace Cineflix\App\Controller;

use Cineflix\App\Dao\ProfilDao;
use Cineflix\App\model\ProfilModel;
use Cineflix\Core\AbstractController;
use Cineflix\Core\Util\AuthConnect;

class Profil extends AbstractController
{

    private ProfilDao $profilDao;
    public function __construct() {
        parent::__construct();
        if(!AuthConnect::isConnected()) {
            header('Location: /');
            exit();
        }

        $this->profilDao = new ProfilDao();
    }
    public function show()
    {
        //TODO valider les infos de la session
        // Et créer l'objet Profil dans le constructeur
        $session = AuthConnect::getSession();
        $email = $session['email'];
        $profil = new ProfilModel();
        return $this->render('profil.show',compact('profil'));
    }

    public function edit()
    {
        $session = AuthConnect::getSession();
        $email = $session['email'];
        $profil = $this->profilDao->read();
        $profil = new ProfilModel();
        return $this->render('profil.edit',compact('profil'));
    }
}
