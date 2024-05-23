<?php
    //mp 8LR632C8o3_t
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
    use ReCaptcha\ReCaptcha;

    class Auth extends AbstractController
    {

        private string $site_key = '6Lfny-ApAAAAAKi890lrpa5LSgY8LcsrUAwE7Y2M';
        private array $session;
        private UserDao $userDao;
        private ProfilDao $profilDao;

        protected string $layout = 'auth';

        public function __construct()
        {
            parent::__construct();
            $this->userDao = new UserDao();
            $this->profilDao = new ProfilDao();
        }
        /**
         * Connexion
         * @return string
         */
        public function signin(): string
        {

            $errors = [];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user = new UserModel();

                $user->addValidation('email',['email', 'require']);
                $user->addValidation('password',['password', 'require']);

                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);

                if($user->isValid() && AuthConnect::verify($user->email, $user->getPassword())) {
                    $user->setPassword('');

                    $data = $this->userDao->findOneBy('email',$user->email, [
                        'select' => ['user.id', 'user.role', 'profil.nom','profil.prenom', 'profil.point'],
                        'contain' => ['profil' => 'user.id = profil.user_id']
                    ]);

                    $user->hydrate($data);

                    AuthConnect::connect($user->email, [
                        'id'     => $user->id,
                        'nom'    => $user->profil->nom,
                        'prenom' => $user->profil->prenom,
                        'point'  => $user->profil->point,
                        'role'   => $user->role,
                    ]);
                    MessageFlash::create('Connecté',$type = 'valide');
                    header('Location: /');
                    exit;
                } else {
                    MessageFlash::create('Identifiant / Mot de passe invalide !!!',$type = 'invalide');
                }

                $errors = $user->getErrors();
            }

            $this->addJavascript(...['path' => 'js/app.js', 'module' => true]);

            return $this->render('Auth.signin', [$errors]);

        }

        /**
         * Inscription
         * @return string
         */
        public function signup(): string
        {
            $user = new UserModel();
            if(AuthConnect::isConnected()) {
                header('Location: /');
                exit();
            }

            $errors = [];


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $user->hydrate($_POST);
                $user->setPassword($_POST['password']);
                $user->setPasswordConfirm($_POST['password_confirm']);
                $user->addValidation('email',['email', 'require']);
                $user->addValidation('password',['password', 'equal', 'require']);
                $user->profil->addValidation('nom',['alpha', 'require']);
                $user->profil->addValidation('prenom',['alpha', 'require']);


                $exist = $this->userDao->isExist('email', $user->email);

                $user_is_valid =$user->isValid();
                $profil_is_valid = $user->profil->isValid();

                $recaptcha = new ReCaptcha($this->site_key);
                $response = $recaptcha->verify($_POST['g-recaptcha-response']);

                $valid = $user_is_valid && $profil_is_valid && !$exist && $response->isSuccess();
                if($valid && $this->userDao->create($user)) {

                    AuthConnect::connect($user->email,[
                        'id'     => $this->userDao->getLastId(),
                        'nom'    => $user->profil->nom,
                        'prenom' => $user->profil->prenom,
                        'point'  => $user->profil->point,
                        'role'   => $user->role,
                    ]);

                    MessageFlash::create('Merci de compléter votre profil', $type = 'valide');

                    header('Location: /Signup/Finalise');
                    exit;
                }

                if($exist) MessageFlash::create('Compte existant !', $type = 'warning');

                $errors = array_merge($user->getErrors(),$user->profil->getErrors());
                if(isset($exist) && $exist) $errors['email'] = ['type'   => 'invalid',
                                                                'message' =>'Email déja utilisé !'];
                if(!$response->isSuccess()) $errors['recaptcha'] = ['type'   => 'invalid',
                                                                    'message' =>'Merci de valider le Recaptcha !'];
            }

            $this->addJavascript(...['path'  => 'https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit',
                                     'defer' => true,
                                     'head'  => true]);

            $this->addJavascript(...['path' => 'js/class/reCaptcha.js', 'module' => true]);
            $this->addJavascript(...['path' => 'js/app.js', 'module' => true]);

            return $this->render('Auth.signup', compact('user','errors'));

        }

        /**
         * Finalisation inscription, edition du Profil
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


                $profil->addValidation('numero_voie',['alphaNumeric']);
                $profil->addValidation('type_voie',['alpha']);
                $profil->addValidation('nom_voie',['alphaNumeric']);
                $profil->addValidation('code_postale',['numeric']);
                $profil->addValidation('ville',['alpha']);

                if($profil->isValid() && $this->profilDao->update($profil)) {
                    MessageFlash::create('Welcome, Vous êtez connecté', $type = 'valide');

                    header('Location: /');
                    exit;
                }
            }

            $errors = $profil->getErrors();

            $this->addJavascript(...['path' => 'js/app.js', 'module' => true]);

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
