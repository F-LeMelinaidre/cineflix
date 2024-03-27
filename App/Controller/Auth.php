<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\Model\AccountModel;
    use Cineflix\App\Model\DAO\UserDao;
    use Cineflix\Core\AbstractController;
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

            $user = new AccountModel();
            $user->mail = Security::sanitize($_POST['mail']);
            $user->password = Security::sanitize($_POST['password']);


            return $this->render('Auth.signin', []);

        }

        public function signup(): string
        {
            $errors = [];
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {

                $nom = Security::sanitize($_POST['nom']);
                $prenom = Security::sanitize($_POST['prenom']);
                $mail = Security::sanitize($_POST['mail']);
                $password = Security::sanitize($_POST['password']);
                $password_confirm = Security::sanitize($_POST['password_confirm']);

                foreach($_POST as $key => $val) {
                    if (empty($val)) $errors[$key] = $this->msg_errors['empty'];
                }

                if (!preg_match(Regex::getPattern('carateres'), $nom))     $errors['nom'] = $this->msg_errors['carateres'];
                if (!preg_match(Regex::getPattern('carateres'), $prenom))  $errors['prenom'] = $this->msg_errors['carateres'];
                if (!preg_match(Regex::getPattern('mail'), $mail))         $errors['mail'] = $this->msg_errors['mail'];
                if (!preg_match(Regex::getPattern('password'), $password)) $errors['password'] = $this->msg_errors['password'];


                $userDao = new UserDao();
                if ($userDao->isExist($mail)) $errors['mail'] = $this->msg_errors['exist'];

                if ($password !== $password_confirm && !isset($errors['password'])) $errors['password'] = $this->msg_errors['not_equal'];

                if (!isset($errors) ) {
                    echo 'ok';
                } else {
                    var_dump($errors);
                }


            }
            return $this->render('Account.signup', []);

        }

        public function signout()
        {

        }
    }
