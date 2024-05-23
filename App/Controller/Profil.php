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
        private UserDao $userDao;
        private array $session;

        public function __construct() {
            parent::__construct();
            if(!AuthConnect::isConnected()) {
                header('Location: /');
                exit();
            }

            $this->session = AuthConnect::getSession();
            $this->userDao = new UserDao();
            $this->page_active = 'Profil';
        }

        /**
         * @return string
         */
        public function show()
        {

            $data = $this->dao->findOneBy('user_id', $this->session['id'],[
                'select'    => ['profil.*', 'user.role', 'user.email'],
                'contain'   => ['user' => 'profil.user_id = user.id']
                ]);

            $profil = new ProfilModel($data);
            return $this->render('profil.show',compact('profil'));
        }

        /**
         * @return string
         */
        public function editIdentite()
        {

            $params = [
                'select' => ['user_id','nom', 'prenom', 'date_naissance', 'created', 'modified']
            ];

            $data = $this->dao->findOneBy('user_id',$this->session['id'], $params);
            $profil = new ProfilModel($data);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                //TODO verifier l'id

                $profil->hydrate($_POST);
                $profil->setId($this->session['id']);

                $profil->addValidation('nom',['alpha', 'require']);
                $profil->addValidation('prenom',['alpha', 'require']);
                $profil->addValidation('date_naissance',['date']);


                if($profil->isValid() && $this->dao->update($profil)) {

                    unset($data['user_id']);
                    unset($data['created']);
                    unset($data['modified']);

                    $data_updated = $this->dao->getDataUpdated();

                    /*var_dump($data);
                    var_dump($data_updated);*/

                    // compare $data (issue de la bd) à l'object $profil transformé en array
                    // si ils sont différents informe de la modification des données en bd
                    // TODO faire cette vérification avant et ne pas faire l'update si ils sont identiques
                    $array_diff = array_diff($data,$data_updated);
                    if(!empty($array_diff)) MessageFlash::create('Identité modifié',$type = 'valide');

                    header('Location: /Profil');
                    exit();
                }

            }

            $errors = $profil->getErrors();

            $this->addJavascript(...['path' => 'js/app.js', 'module' => true]);

            return $this->render('profil.editIdentite',compact('profil', 'errors'));
        }

        /**
         * @return string
         */
        public function editAdresse()
        {
            $params = [
                'select' => ['user_id','numero_voie', 'type_voie', 'nom_voie', 'code_postale', 'ville', 'created', 'modified']
            ];

            $data = $this->dao->findOneBy('user_id', $this->session['id'], $params);
            $profil = new ProfilModel($data);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $profil->hydrate($_POST);
                $profil->setId($this->session['id']);

                $profil->addValidation('numero_voie', ['alphaNumeric','require']);
                $profil->addValidation('type_voie', ['alpha','require']);
                $profil->addValidation('nom_voie', ['alpha','require']);
                $profil->addValidation('code_postale', ['numeric', 'require']);
                $profil->addValidation('ville', ['alpha','require']);



                if($profil->isValid() && $this->dao->update($profil)) {
                    unset($data['user_id']);
                    unset($data['created']);
                    unset($data['modified']);

                    $data_updated = $this->dao->getDataUpdated();

                    $array_diff = array_diff($data,$data_updated);
                    if(!empty($array_diff)) MessageFlash::create('Adresse modifié',$type = 'valide');

                    header('Location: /Profil');
                    exit();
                }

            }

            $errors = $profil->getErrors();

            $this->addJavascript(...['path' => 'js/app.js', 'module' => true]);

            return $this->render('profil.editAdresse',compact('profil', 'errors'));
        }

        /**
         * @return string
         */
        public function editAuthentification()
        {
            $data = $this->userDao->findOneBy('id',$this->session['id'],['select' => ['email', 'created', 'modified']]);
            $user = new UserModel($data);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                $user->hydrate($_POST);
                $user->setId($this->session['id']);

                $user->addValidation('email',['email']);
                $user->addValidation('password',['password']);

                $is_valid =$user->isValid();

                if($is_valid && $this->userDao->update($user)) {
                    $items = [];

                    if($user->getPassword()) $items[] = 'mot de passe';
                    if($user->email !== $data['email']) $items[] = 'email';

                    $message = implode(' et ', $items). ' modifié';
                    if(count($items) > 1) $message .= 's';

                    if(count($items)) MessageFlash::create($message,$type = 'valide');

                    header('Location: /Profil');
                    exit();
                }

            }

            $errors = $user->getErrors();

            $this->addJavascript(...['path' => 'js/app.js', 'module' => true]);
            $this->addJavascript(...['path' => 'js/class/generatePassword.js', 'module' => true]);

            return $this->render('profil.editAuthentification',compact('user','errors'));
        }
    }
