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
                        'select' => ['u.id','p.nom AS profil_nom','p.prenom AS profil_prenom','p.point profil_point'],
                        'hasOne' => ['profil']
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
            $form = [];
            $errors = [];


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

                    } elseif ($this->userDao->isExist($email)) {
                        $errors['email'] = $this->msg_errors['exist'];
                    }

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

                $pwd_confirm = Security::sanitize($_POST['password_confirm']);

                if ($password !== $pwd_confirm && !isset($errors['password'])) $errors['password'] = $this->msg_errors['not_equal'];



                if (empty($errors)) {

                    $user = new UserModel();
                    $user->email = $email;
                    $user->hashPassword($password);
                    $user->setProfil(['nom' => $nom, 'prenom' => $prenom]);

                    if($this->userDao->create($user)) {
                        //TODO CAPTCHA
                        //TODO prevoir la validation du compte par envoi de mail
                        AuthConnect::connect($email,[
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

                $form = [
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'password'=> $password,
                    'password_confirm' => $pwd_confirm,
                ];
            }
            return $this->render('Auth.signup', [ 'form' => $form, 'errors' => $errors ]);

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

            $profil = $this->profilDao->findOneBy(['user_id' => $this->session['id']]);

            var_dump($profil);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $profil->setNumeroVoie($_POST['numero_voie']);
                $profil->setTypeVoie($_POST['type_voie']);
                $profil->setNomVoie($_POST['nom_voie']);
                $profil->setCodePostale(intval($_POST['code_postale']));
                $profil->setVille($_POST['ville']);

                $profil->addValidation('numero_voie',['rule' => 'alphaNumeric', 'require' => true]);
                $profil->addValidation('type_voie',['rule' => 'alpha', 'require' => true]);
                $profil->addValidation('nom_voie',['rule' => 'alphaNumeric', 'require' => true]);
                $profil->addValidation('code_postale',['rule' => 'numeric', 'require' => true]);
                $profil->addValidation('ville',['rule' => 'alpha', 'require' => true]);

                if($profil->isValid() && $this->profilDao->update($profil)) {
                    MessageFlash::create('Welcome, Vous êtez connecté', $type = 'valide');

                    header('Location: /');
                    exit;
                }
            }


            $errors = $profil->getErrors();

            return $this->render('Auth.finalizeSignup', [ 'profil' => $profil, 'errors' => $errors ]);
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
