<?php

namespace Cineflix\App\Controller;

use Cineflix\App\Dao\ProfilDao;
use Cineflix\App\DAO\UserDao;
use Cineflix\App\model\ProfilModel;
use Cineflix\App\Model\UserModel;
use Cineflix\Core\AbstractController;
use Cineflix\Core\Util\AuthConnect;
use Cineflix\Core\Util\MessageFlash;
use Cineflix\Core\Util\Regex;
use Cineflix\Core\Util\Security;

class Profil extends AbstractController
{

    private ProfilDao $profilDao;

    private array $session;


    private $msg_errors = [
        'empty'     => 'Champ obligatoire !',
        'alpha'     => 'Seul les majuscules, minuscules et caratères accentués acceptés !',
        'email'     => 'Format invalide (norme RFC2822) !',
        'password'  => 'Doit contenir au minimum 8 caratères, un caratères majuscule et minuscule, un chiffre, et un caratères spéciaux !?:_\-*#&%+',
        'exist'     => 'Email déja utilisé !',
        'not_equal' => 'Les mots de passes ne sont pas identique !'
    ];

    public function __construct() {
        parent::__construct();
        if(!AuthConnect::isConnected()) {
            header('Location: /');
            exit();
        }

        $this->session = AuthConnect::getSession();
        $this->profilDao = new ProfilDao();

    }
    public function show()
    {
        //TODO valider les infos de la session
        // Et créer l'objet Profil dans le constructeur
        $options = [
            'user' => [ 'select' => ['email']]
        ];
        $profil = $this->profilDao->findByUserToken($this->session['token']);

        return $this->render('profil.show',['profil' => $profil]);
    }

    public function editIdentite()
    {


        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //TODO verifier l'id

            $profil = new ProfilModel();
            $profil->user_id = $_POST['user_id'];
            $profil->setNom($_POST['nom']);
            $profil->setPrenom($_POST['prenom']);
            $profil->setDateNaissance($_POST['date_naissance']);

            $profil->isValid();

        } else{
            $params = [
                'select' => ['user_id','nom', 'prenom', 'date_naissance']
            ];
            $profil = $this->profilDao->findByUserToken($this->session['token'], $params);
        }


        return $this->render('profil.editIdentite',['profil' => $profil]);
    }

    public function editAdresse()
    {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //TODO verifier l'id

            $profil = new ProfilModel();
            $profil->user_id = $_POST['user_id'];
            $profil->setNumeroVoie($_POST['numero_voie']);
            $profil->setTypeVoie($_POST['type_voie']);
            $profil->setNomVoie($_POST['nom_voie']);
            $profil->setCodePostale(intval($_POST['code_postale']));
            $profil->setVille($_POST['ville']);

            $profil->isValid();
        } else {
            $params = [
                'select' => ['user_id','numero_voie', 'type_voie', 'nom_voie', 'code_postale', 'ville']
            ];

            $profil = $this->profilDao->findByUserToken($this->session['token'], $params);
        }
        return $this->render('profil.editAdresse',['profil' => $profil]);
    }

    public function editAuthentification()
    {
        $params = [
            'user' => [
                'select' => ['email']
            ]
        ];
        $userDao = new UserDao();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new UserModel();
            $user->id = $_POST['user_id'];
            $user->setEmail($_POST['email']);


        } else {
            $user = $userDao->findOneBy(['token' => $this->session['token']]);
        }



        return $this->render('profil.editAuthentification',['user' => $user]);
    }
}
