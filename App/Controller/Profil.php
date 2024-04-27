<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\Dao\ProfilDao;
    use Cineflix\App\DAO\UserDao;
    use Cineflix\App\model\ProfilModel;
    use Cineflix\App\Model\UserModel;
    use Cineflix\Core\AbstractController;
    use Cineflix\Core\Util\AuthConnect;
    use Cineflix\Core\Util\MessageFlash;

    class Profil extends AbstractController
    {

        private ProfilDao $profilDao;

        private array $session;

        /**
         *
         */
        public function __construct() {
            parent::__construct();
            if(!AuthConnect::isConnected()) {
                header('Location: /');
                exit();
            }

            $this->session = AuthConnect::getSession();
            $this->profilDao = new ProfilDao();

        }

        /**
         * @return string
         */
        public function show()
        {

            $data = $this->profilDao->findOneBy('user_id', $this->session['id'],[
                'select'    => ['profil.*', 'user.email'],
                'contain'   => ['user']
                ]);
            $profil = new ProfilModel($data);
            return $this->render('profil.show',['profil' => $profil]);
        }

        /**
         * @return string
         */
        public function editIdentite()
        {


            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                //TODO verifier l'id

                $profil = new ProfilModel();

                $profil->addValidation('nom',['alpha', 'require']);
                $profil->addValidation('prenom',['alpha', 'require']);
                $profil->addValidation('date_naissance',['alphaNumeric']);

                $profil->setId($this->session['id']);
                $profil->setNom($_POST['nom']);
                $profil->setPrenom($_POST['prenom']);
                $profil->setDateNaissance($_POST['date_naissance']);




                if($profil->isValid() && $this->profilDao->update($profil)) {
                    MessageFlash::create('Identité modifié',$type = 'valide');
                    header('Location: /Profil');
                    exit();
                }

            } else{
                $params = [
                    'select' => ['user_id','nom', 'prenom', 'date_naissance', 'created', 'modified']
                ];

                $data = $this->profilDao->findOneBy('user_id',$this->session['id'], $params);
                $profil = new ProfilModel($data);
            }

            $errors = $profil->getErrors();

            return $this->render('profil.editIdentite',['profil' => $profil, 'errors' => $errors]);
        }

        /**
         * @return string
         */
        public function editAdresse()
        {

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                //TODO verifier l'id

                $profil = new ProfilModel();

                $profil->addValidation('numero_voie', ['alphaNumeric','require']);
                $profil->addValidation('type_voie', ['alpha','require']);
                $profil->addValidation('nom_voie', ['alpha','require']);
                $profil->addValidation('code_postale', ['numeric', 'require']);
                $profil->addValidation('ville', ['alpha','require']);

                $profil->setId($this->session['id']);
                $profil->setNumeroVoie($_POST['numero_voie']);
                $profil->setTypeVoie($_POST['type_voie']);
                $profil->setNomVoie($_POST['nom_voie']);
                $profil->setCodePostale(intval($_POST['code_postale']));
                $profil->setVille($_POST['ville']);

                if($profil->isValid() && $this->profilDao->update($profil)) {
                    MessageFlash::create('Adresse modifié',$type = 'valide');
                    header('Location: /Profil');
                    exit();
                }

            } else {
                $params = [
                    'select' => ['user_id','numero_voie', 'type_voie', 'nom_voie', 'code_postale', 'ville', 'created', 'modified']
                ];

                $data = $this->profilDao->findOneBy('user_id', $this->session['id'], $params);

                $profil = new ProfilModel($data);
            }

            $errors = $profil->getErrors();

            return $this->render('profil.editAdresse',['profil' => $profil, 'errors' => $errors]);
        }

        /**
         * @return string
         */
        public function editAuthentification()
        {
            $userDao = new UserDao();

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                $user = new UserModel();
                $user->setId($this->session['id']);
                $user->setEmail($_POST['email']);

            } else {
                $user = $userDao->findOneBy(['id' => $this->session['id']],['select' => ['email']]);
            }



            return $this->render('profil.editAuthentification',['user' => $user]);
        }
    }
