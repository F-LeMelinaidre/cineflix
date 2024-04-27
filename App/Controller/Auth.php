<?php
    //mp A5FWNS2ekaejTqt?!
    // mp major rRTxrTTMhLkQf4W!?
    namespace Cineflix\App\Controller;

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

        private $msg_errors = [
            'empty'     => 'Champ obligatoire !',
            'alpha'     => 'Seul les majuscules, minuscules et caratères accentués acceptés !',
            'email'     => 'Format invalide (norme RFC2822) !',
            'password'  => 'Doit contenir au minimum 8 caratères, un caratères majuscule et minuscule, un chiffre, et un caratères spéciaux !?:_\-*#&%+',
            'exist'     => 'Email déja utilisé !',
            'not_equal' => 'Les mots de passes ne sont pas identique !'
        ];

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
            $errors = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $user = new UserModel();

                $user->addValidation('email',['rule' => 'email', 'require' => true]);
                $user->addValidation('password',['rule' => 'password', 'require' => true]);

                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);

                if($user->isValid() && AuthConnect::verify($user->email, $user->getPassword())) {
                    $user->setPassword('');

                    $data = $this->userDao->findOneBy('email',$user->email, [
                        'select' => ['user.id','profil.nom','profil.prenom','profil.point'],
                        'contain' => ['profil']
                    ]);

                    $user->hydrate($data);

                    AuthConnect::connect($user->email, [
                        'id'     => $user->getId(),
                        'nom'    => $user->getProfil()->nom,
                        'prenom' => $user->getProfil()->prenom,
                        'point'  => $user->getProfil()->point,
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
            $user = new UserModel();
            $profil = new ProfilModel();
            $user->setProfil($profil);


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);
                $user->setPasswordConfirm($_POST['password_confirm']);

                $user->addValidation('email',['email', 'require']);
                $user->addValidation('password',['password', 'equal', 'require']);


                $profil->setNom($_POST['nom']);
                $profil->setPrenom($_POST['prenom']);
                $user->setProfil($profil);

                $profil->addValidation('nom',['alpha', 'require']);
                $profil->addValidation('prenom',['alpha', 'require']);

                $exist = $this->userDao->isExist('email', $user->email);

                $user_is_valid =$user->isValid();
                $profil_is_valid = $profil->isValid();

                $valid = $user_is_valid && $profil_is_valid && !$exist;

                if($valid && $this->userDao->create($user)) {

                    AuthConnect::connect($user->email,[
                        'id'     => $this->userDao->getLastInsertId(),
                        'nom'    => $user->getProfil()->nom,
                        'prenom' => $user->getProfil()->prenom,
                        'point'  => $user->getProfil()->point,
                    ]);

                    MessageFlash::create('Merci de compléter votre profil', $type = 'valide');

                    header('Location: /Signup/Finalise');
                    exit;
                }
            }
            $errors = array_merge($user->getErrors(),$profil->getErrors());
            if(isset($exist) && $exist) $errors['email'] = 'Email déja utilisé !';

            return $this->render('Auth.signup', compact('user','errors'));

        }

        /**
         * @return void
         */
        public function finalizeSignup(): string
        {
            if(!AuthConnect::isConnected()) {
                header('Location: /');
                exit();
            }

            $this->session = AuthConnect::getSession();
            $user = new ProfilModel();
            $user->setId($this->session['id']);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                $user->setNumeroVoie($_POST['numero_voie']);
                $user->setTypeVoie($_POST['type_voie']);
                $user->setNomVoie($_POST['nom_voie']);
                $user->setCodePostale(intval($_POST['code_postale']));
                $user->setVille($_POST['ville']);
                $user->setCreated($this->session['last_connect']);


                $user->addValidation('numero_voie',['alphaNumeric', 'require']);
                $user->addValidation('type_voie',['alpha', 'require']);
                $user->addValidation('nom_voie',['alphaNumeric', 'require']);
                $user->addValidation('code_postale',['numeric', 'require']);
                $user->addValidation('ville',['alpha', 'require']);

                if($user->isValid() && $this->profilDao->update($user)) {
                    MessageFlash::create('Welcome, Vous êtez connecté', $type = 'valide');

                    header('Location: /');
                    exit;
                }
            }


            $errors = $user->getErrors();

            return $this->render('Auth.finalizeSignup', [ 'profil' => $user, 'errors' => $errors ]);
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
