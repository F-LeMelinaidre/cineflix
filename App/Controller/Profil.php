<?php

namespace Cineflix\App\Controller;

use Cineflix\App\Dao\ProfilDao;
use Cineflix\App\model\ProfilModel;
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
        $data = $this->profilDao->findByUserToken($this->session['token']);

        $profil = new ProfilModel($data);

        return $this->render('profil.show',['profil' => $profil]);
    }
    public function edit($slug = null)
    {
        $view = strtolower($slug);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [];
            if (isset($_POST['nom']) && !empty($_POST['nom'])) {
                $data['nom'] = Security::sanitize($_POST['nom']);

                if(!preg_match(Regex::getPattern('alpha'), $data['nom'])) {
                    $errors['nom'] = $this->msg_errors['alpha'];
                }
            } else {
                $errors['nom'] = $this->msg_errors['empty'];
                $data['nom'] = '';
            }

            if (isset($_POST['prenom']) && !empty($_POST['prenom'])) {
                $data['prenom'] = Security::sanitize($_POST['prenom']);

                if(!preg_match(Regex::getPattern('alpha'), $data['prenom'])) {
                    $errors['prenom'] = $this->msg_errors['alpha'];
                }
            } else {
                $errors['prenom'] = $this->msg_errors['empty'];
                $data['prenom'] = '';
            }

            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $data['email'] = Security::sanitize($_POST['email']);

                if (!preg_match(Regex::getPattern('email'), $data['email'])) {
                    $errors['email'] = $this->msg_errors['email'];

                }
                //TODO verifier si le mail existe et exclure le compte actuelle de la recherche

            } else {
                $errors['email'] = $this->msg_errors['empty'];
                $data['email'] = '';
            }

            if (isset($_POST['date_naissance']) && !empty($_POST['date_naissance'])) {
                $data['date_naissance'] = Security::sanitize($_POST['date_naissance']);


                //TODO regex date

            } else {
                $errors['date_naissance'] = $this->msg_errors['empty'];
                $data['date_naissance'] = '';
            }

            if (isset($_POST['numero_voie']) && !empty($_POST['numero_voie'])) {
                $data['numero_voie'] = Security::sanitize($_POST['numero_voie']);


                //TODO regex alphaNumeric

            } else {
                $errors['numero_voie'] = $this->msg_errors['empty'];
                $data['numero_voie'] = '';
            }

            if (isset($_POST['type_voie']) && !empty($_POST['type_voie'])) {
                $data['type_voie'] = Security::sanitize($_POST['type_voie']);


                //TODO vérif avec regex alpha

            } else {
                $errors['type_voie'] = $this->msg_errors['empty'];
                $data['type_voie'] = '';
            }

            if (isset($_POST['nom_voie']) && !empty($_POST['nom_voie'])) {
                $data['nom_voie'] = Security::sanitize($_POST['nom_voie']);


                //TODO vérif avec regex alpha

            } else {
                $errors['nom_voie'] = $this->msg_errors['empty'];
                $data['nom_voie'] = '';
            }

            if (isset($_POST['code_postale']) && !empty($_POST['code_postale'])) {
                $data['code_postale'] = Security::sanitize($_POST['code_postale']);


                //TODO vérif avec regex numeric

            } else {
                $errors['code_postale'] = $this->msg_errors['empty'];
                $data['code_postale'] = '';
            }


            if (isset($_POST['ville']) && !empty($_POST['ville'])) {
                $data['ville'] = Security::sanitize($_POST['ville']);


                //TODO vérif avec regex alpha

            } else {
                $errors['ville'] = $this->msg_errors['empty'];
                $data['ville'] = '';
            }

            if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
                $data['user_id'] = $_POST['user_id'];
            }

            if (empty($errors)) {
                $profil = new ProfilModel($data);

                $this->profilDao->update($profil);

                MessageFlash::create('Profil finalisé',$type = 'valide');

                header('Location: /');
                exit();
            }
        } else {
            $data = $this->profilDao->findByUserToken($this->session['token']);

            $profil = new ProfilModel($data);
        }
        //TODO reflechir a mettre les champ nom prenom email en readOnly lors de l'edition du profil en fin d'inscription
        return $this->render("profil.edit-$view",['profil' => $profil]);
    }
}
