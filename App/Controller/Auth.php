<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\Model\DAO\UserDao;
    use Cineflix\App\Model\UserModel;
    use Cineflix\Core\AbstractController;
    use Cineflix\Core\Util\Auth;
    use Cineflix\Core\Util\MessageFlash;
    use Cineflix\Core\Util\Regex;
    use Cineflix\Core\Util\Security;

    class Auth extends AbstractController
    {

        private $msg_errors = [
            'empty'     => 'Champ obligatoire !',
            'carateres' => 'Seul les majuscules, minuscules et caratères accentués acceptés !',
            'mail'      => 'Format invalide (norme RFC2822) !',
            'password'  => 'Doit contenir au minimum 8 caratères, un caratères majuscule et minuscule, un chiffre, et un caratères spéciaux !?:_\-*#&%+',
            'exist'     => 'Email déja utilisé !',
            'not_equal'     => 'Les mots de passes ne sont pas identique !'
        ];

        protected string $layout = 'auth';

        public function signin(): string
        {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user = new UserModel();
                $user->mail = Security::sanitize($_POST['mail']);
                $password = Security::sanitize($_POST['password']);
            }


            return $this->render('Auth.signin', []);

        }

        public function signup(): string
        {
            $errors = [];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nom = (isset($_POST['nom'])) ? Security::sanitize($_POST['nom']) : '';
                $prenom = (isset($_POST['prenom'])) ? Security::sanitize($_POST['prenom']) : '';
                $mail = (isset($_POST['mail'])) ? Security::sanitize($_POST['mail']) : '';
                $password = (isset($_POST['password'])) ? Security::sanitize($_POST['password']) : '';
                $password_confirm = (isset($_POST['password_confirm'])) ? Security::sanitize($_POST['password_confirm']) : '';

                if (empty($nom)) {
                    $errors['nom'] = $this->msg_errors['empty'];

                } elseif(!preg_match(Regex::getPattern('carateres'), $nom)) {
                    $errors['nom'] = $this->msg_errors['carateres'];
                }

                if (empty($prenom)) {
                    $errors['prenom'] = $this->msg_errors['empty'];

                } elseif(!preg_match(Regex::getPattern('carateres'), $prenom)) {
                        $errors['prenom'] = $this->msg_errors['carateres'];
                }

                if (empty($mail)) {
                    $errors['mail'] = $this->msg_errors['empty'];

                } elseif (!preg_match(Regex::getPattern('mail'), $mail)) {
                    $errors['email'] = $this->msg_errors['mail'];

                } else {

                    $userDao = new UserDao();
                    if ($userDao->isExist($mail))
                        $errors['mail'] = $this->msg_errors['exist'];
                }

                if (empty($password)) {
                    $errors['password'] = $this->msg_errors['empty'];

                } elseif (!preg_match(Regex::getPattern('password'), $password)) {
                    $errors['password'] = $this->msg_errors['password'];

                }

                if ($password !== $password_confirm && !isset($errors['password'])) $errors['password'] = $this->msg_errors['not_equal'];

                $user = new UserModel($nom,$prenom, $mail);
                $user->setPassword($password);

                if (empty($errors) && $userDao->save($user)) {
                    //TODO COPIE COLLE DU PROJET MVC A MODIFIER

                    \Cineflix\Core\Util\Auth::connect(['email' => $user->email, 'username' => $user->username, 'last_connect' =>
                        $user->getLastConnectFr()]);
                    MessageFlash::create('Connecté',$type = 'valide');

                    header('Location: /');
                    exit;
                } else {
                    var_dump($errors);
                }


            }
            return $this->render('Account.signup', [$errors]);

        }

        public function signout()
        {

        }
    }
