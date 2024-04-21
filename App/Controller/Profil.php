<?php

namespace Cineflix\App\Controller;

use Cineflix\App\Dao\ProfilDao;
use Cineflix\App\model\ProfilModel;
use Cineflix\Core\AbstractController;
use Cineflix\Core\Util\AuthConnect;

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
        echo 'tableau de la session<br>';
        var_dump($this->session);
        $this->profilDao = new ProfilDao();

    }
    public function show()
    {
        //TODO valider les infos de la session
        // Et créer l'objet Profil dans le constructeur
        $data = $this->profilDao->findByUserToken($this->session['token']);


        $profil = new ProfilModel($data);

        return $this->render('profil.show',['profil' => $profil]);
    }

    public function edit($slug = null)
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo 'tableau du POST<br>';
            var_dump($_POST);

            if (isset($_POST['nom']) && !empty($_POST['nom'])) {
                $nom = Security::sanitize($_POST['nom']);

                if(!preg_match(Regex::getPattern('alpha'), $nom)) {
                    $errors['nom'] = $this->msg_errors['alpha'];
                }
            } else {
                $errors['nom'] = $this->msg_errors['empty'];
                $nom = '';
            }

            if (isset($_POST['prenom']) && !empty($_POST['prenom'])) {
                $prenom = Security::sanitize($_POST['prenom']);

                if(!preg_match(Regex::getPattern('alpha'), $prenom)) {
                    $errors['prenom'] = $this->msg_errors['alpha'];
                }
            } else {
                $errors['prenom'] = $this->msg_errors['empty'];
                $prenom = '';
            }

            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $email = Security::sanitize($_POST['email']);

                if (!preg_match(Regex::getPattern('email'), $email)) {
                    $errors['email'] = $this->msg_errors['email'];

                }
                //TODO verifier si le mail existe et exclure le compte actuelle de la recherche

            } else {
                $errors['email'] = $this->msg_errors['empty'];
                $email = '';
            }

            if (isset($_POST['password']) && !empty($_POST['password'])) {
                $password = Security::sanitize($_POST['password']);

                if(!preg_match(Regex::getPattern('password'), $password)) {
                    $errors['password'] = $this->msg_errors['password'];
                }
            } else {
                $errors['password'] = $this->msg_errors['password'];
                $password = '';
            }

            die();
        } else {
            $data = $this->profilDao->findByUserToken($this->session['token']);

            $profil = new ProfilModel($data);
        }


        return $this->render('profil.edit',['profil' => $profil]);
    }
}
