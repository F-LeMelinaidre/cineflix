<?php
    //mp A5FWNS2ekaejTqt?!
    // mp major rRTxrTTMhLkQf4W!?
    namespace Cineflix\App\Controller;

    use Cineflix\App\DAO\List\Role;
    use Cineflix\App\DAO\ProfilDao;
    use Cineflix\App\DAO\UserDao;
    use Cineflix\App\model\ProfilModel;
    use Cineflix\App\Model\UserModel;
    use Cineflix\Core\AbstractController;
    use Cineflix\Core\Util\AuthConnect;
    use Cineflix\Core\Util\MessageFlash;
    use Cineflix\Core\Util\Regex;
    use Cineflix\Core\Util\Security;

    class Auth extends AbstractController
    {
        private UserDao $userDao;
        private ProfilDao $profilDao;

        private array $session;

        public function __construct()
        {
            parent::__construct();

            $this->userDao = new UserDao();
            $this->profilDao = new ProfilDao();

        }

        protected string $layout = 'auth';

        /**
         * @return string
         */
        public function signin(): string
        {
            if(AuthConnect::isConnected()) {
                header('Location: /');
                exit();
            }

            $errors = [];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $user = new UserModel();
                $user->addProfil();

                $user->addValidation('email',['email', 'require']);
                $user->addValidation('password',['password', 'require']);

                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);

                if($user->isValid() && AuthConnect::verify($user->email, $user->getPassword())) {
                    $user->setPassword('');

                    $data = $this->userDao->findOneBy('email',$user->email, [
                        'select' => ['user.id', 'user.role','profil.nom','profil.prenom','profil.point'],
                        'contain' => ['profil' => 'user.id = profil.user_id']
                    ]);

                    $user->hydrate($data);

                    AuthConnect::connect($user->email, [
                        'id'     => $user->getId(),
                        'nom'    => $user->profil->nom,
                        'prenom' => $user->profil->prenom,
                        'point'  => $user->profil->point,
                        'role'   => $user->getRole(),
                    ]);

                    MessageFlash::create('Connecté',$type = 'valide');

                    header('Location: /');
                    exit;
                } else {
                    MessageFlash::create('Identifiant / Mot de passe invalide !!!',$type = 'invalide');
                }

                $errors = $user->getErrors();
            }

            return $this->render('Auth.signin', [$errors]);

        }

        /**
         * @return string
         */
        public function signup(): string
        {

            if(AuthConnect::isConnected()) {
                header('Location: /');
                exit();
            }

            $user = new UserModel();
            $user->addProfil();


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user->setRole(Role::ADHERENT->value);
                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);
                $user->setPasswordConfirm($_POST['password_confirm']);

                $user->addValidation('email',['email', 'require']);
                $user->addValidation('password',['password', 'equal', 'require']);


                $user->profil->setNom($_POST['nom']);
                $user->profil->setPrenom($_POST['prenom']);

                $user->profil->addValidation('nom',['alpha', 'require']);
                $user->profil->addValidation('prenom',['alpha', 'require']);

                $exist = $this->userDao->isExist('email', $user->email);

                $user_is_valid =$user->isValid();
                $profil_is_valid = $user->profil->isValid();
                $valid = $user_is_valid && $profil_is_valid && !$exist;

                if($valid && $this->userDao->create($user)) {

                    AuthConnect::connect($user->email,[
                        'id'     => $this->userDao->getLastId(),
                        'nom'    => $user->profil->nom,
                        'prenom' => $user->profil->prenom,
                        'point'  => $user->profil->point,
                        'role'   => $user->getRole(),
                    ]);

                    MessageFlash::create('Merci de compléter votre profil', $type = 'valide');

                    header('Location: /Signup/Finalise');
                    exit;
                }
            }
            $errors = array_merge($user->getErrors(),$user->profil->getErrors());
            if(isset($exist) && $exist) $errors['email'] = 'Email déja utilisé !';

            return $this->render('Auth.signup', compact('user','errors'));

        }

        /**
         * @return void
         */
        public function finalizeSignup(): string
        {

            $this->session = AuthConnect::getSession();
            $profil = new ProfilModel();
            $profil->setId($this->session['id']);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                $profil->setNumeroVoie($_POST['numero_voie']);
                $profil->setTypeVoie($_POST['type_voie']);
                $profil->setNomVoie($_POST['nom_voie']);
                $profil->setCodePostale(intval($_POST['code_postale']));
                $profil->setVille($_POST['ville']);
                $profil->setCreated($this->session['last_connect']);


                $profil->addValidation('numero_voie',['alphaNumeric', 'require']);
                $profil->addValidation('type_voie',['alpha', 'require']);
                $profil->addValidation('nom_voie',['alphaNumeric', 'require']);
                $profil->addValidation('code_postale',['numeric', 'require']);
                $profil->addValidation('ville',['alpha', 'require']);

                if($profil->isValid() && $this->profilDao->update($profil)) {
                    MessageFlash::create('Welcome, Vous êtez connecté', $type = 'valide');

                    header('Location: /');
                    exit;
                }
            }


            $errors = $profil->getErrors();

            return $this->render('Auth.finalizeSignup', compact( 'profil', 'errors'));
        }

        /**
         * @return void
         */
        public function signout(): void
        {
            AuthConnect::deconnect();
            MessageFlash::create('Deconnecté',$type = 'erreur');
            header('Location: /');
            exit;
        }
    }
