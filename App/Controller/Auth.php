<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\Model\DAO\UserDao;
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
            echo 'signin <br>';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo 'post <br>';
                if (isset($_POST['email']) && !empty($_POST['email'])) {
                    $email = Security::sanitize($_POST['email']);

                    if (!preg_match(Regex::getPattern('email'), $email)) {
                        echo 'erreur format email <br>';
                        $errors['email'] = $this->msg_errors['email'];

                    }

                } else {
                    echo 'empty email <br>';
                    $errors['email'] = $this->msg_errors['empty'];
                    $email = '';
                }

                if (isset($_POST['password']) && !empty($_POST['password'])) {
                    $password = Security::sanitize($_POST['password']);

                    if(!preg_match(Regex::getPattern('password'), $password)) {
                        echo 'erreur format password <br>';
                        $errors['password'] = $this->msg_errors['password'];
                    }
                } else {
                    echo 'empty password <br>';
                    $errors['password'] = $this->msg_errors['password'];
                    $password = '';
                }

                if (empty($errors)) {

                    if (AuthConnect::logon('email', $email, $password)) {
                        header('Location: /');
                        exit;
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

                $pwd_confirm = Security::sanitize($_POST['pwd_confirm']);

                if ($password !== $pwd_confirm && !isset($errors['password'])) $errors['password'] = $this->msg_errors['not_equal'];

                if (empty($errors)) {

                    $user = new UserModel();
                    $user->setNom($nom)
                        ->setPrenom($prenom)
                        ->setEmail($email)
                        ->hashPassword($password);

                    $userDao = new UserDao();
                    if ($userDao->save($user)) {

                        AuthConnect::connect([ 'email' => $user->email, 'username' => $user->nom, /*'last_connect' =>
                        $user->getLastConnectFr()*/]);
                        /*MessageFlash::create('Connecté',$type = 'valide');*/

                        header('Location: /');
                        exit;
                    }

                }
            }
            return $this->render('Auth.signup', [$errors]);

        }

        /**
         * @return void
         */
        public function signout()
        {
            AuthConnect::deconnect();
            header('Location: /');
            exit;
        }
    }
