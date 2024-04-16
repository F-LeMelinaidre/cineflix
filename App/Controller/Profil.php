<?php

namespace Cineflix\App\Controller;

use Cineflix\App\AppController;
use Cineflix\App\Model\DAO\UserDao;
use Cineflix\Core\AbstractController;
use Cineflix\Core\Util\AuthConnect;
use PHPUnit\Util\PHP\AbstractPhpProcess;

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
        //TODO valider les infos de la session
        // Et créer l'objet Profil dans le constructeur
        $session = AuthConnect::getSession();
        $email = $session['email'];

        $userDao = new UserDao();
        $profil = $userDao->findUserWithProfilByEmail($email);
        return $this->render('profil.show',compact('profil'));
    }

    public function edit()
    {
        $session = AuthConnect::getSession();
        $email = $session['email'];

        $userDao = new UserDao();
        $profil = $userDao->findUserWithProfilByEmail($email);
        
        return $this->render('profil.edit',compact('profil'));
    }
}
