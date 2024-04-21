<?php
    //mp A5FWNS2ekaejTqt?!
    // mp major rRTxrTTMhLkQf4W!?
    namespace Cineflix\App\Controller;

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
        public function __construct()
        {
            parent::__construct();

            $this->userDao = new UserDao();

        }

        private $msg_errors = [
            'empty'     => 'Champ obligatoire !',
            'alpha'     => 'Seul les majuscules, minuscules et caratères accentués acceptés !',
            'email'     => 'Format invalide (norme RFC2822) !',
            'password'  => 'Doit contenir au minimum 8 caratères, un caratères majuscule et minuscule, un chiffre, et un caratères spéciaux !?:_\-*#&%+',
            'exist'     => 'Email déja utilisé !',
            'not_equal' => 'Les mots de passes ne sont pas identique !'
        ];

        protected string $layout = 'auth';

        /**
         * @return string
         */
        public function signin(): string
        {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (isset($_POST['email']) && !empty($_POST['email'])) {
                    $email = Security::sanitize($_POST['email']);

                    if (!preg_match(Regex::getPattern('email'), $email)) {
                        $errors['email'] = $this->msg_errors['email'];

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

                    $errors['password'] = $this->msg_errors['empty'];
                    $password = '';
                }

                // Si les champs sont valide
                if (empty($errors)) {

                    // Utilise la class AuthConnect, qui à été paramétré en amont dans AppController
                    // Pour vérifier l'existance du compte et la validité du mot de passe
                    if (AuthConnect::verify($email, $password)) {


                        $user = $this->userDao->findOneBy(['email' => $email ], [
                            'select' => ['email'],
                            'hasOne' => [
                                'profil' => [
                                    'select' => ['nom', 'prenom', 'point']
                                ]
                            ]
                        ]);

                        // On le connect en lui passant les paramètre que l on désire mettre en session
                        AuthConnect::connect($email, [
                            'nom'    => $user->getProfil()->nom,
                            'prenom' => $user->getProfil()->prenom,
                            'point'  => $user->getProfil()->point

                        ]);


                        // Utilise la class Core\Util\MessageFlash.php
                        // la class est appelé au niveau de la vue dans \App\View\Layout\main.view
                        MessageFlash::create('Connecté',$type = 'valide');

                        header('Location: /');
                        exit;
                    } else {
                        MessageFlash::create('Identifiant / Mot de passe invalide !!!',$type = 'invalide');
                    }
                }


            }

            return $this->render('Auth.signin', []);

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
                    $user->setPassword($password);
                    $user->setProfil(['nom' => $nom, 'prenom' => $prenom]);

                    if($this->userDao->create($user)) {
                        //TODO CAPTCHA
                        //TODO prevoir la validation du compte par envoi de mail

                        AuthConnect::connect($email,[
                            'nom'    => $user->getProfil()->nom,
                            'prenom' => $user->getProfil()->prenom,
                        ]);

                        MessageFlash::create('Connecté, merci de compléter votre profil', $type = 'valide');

                        header('Location: /Profil/Edit');
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
        public function signout()
        {
            AuthConnect::deconnect();
            MessageFlash::create('Deconnecté',$type = 'erreur');
            header('Location: /');
            exit;
        }
    }
