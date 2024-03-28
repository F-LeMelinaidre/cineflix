<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\Model\DAO\UserDao;
    use Cineflix\App\Model\UserModel;
    use Cineflix\Core\AbstractController;
    use Cineflix\Core\Util\AuthConnect;
    use Cineflix\Core\Util\MessageFlash;
    use Cineflix\Core\Util\Security;

    class Auth extends AbstractController
    {

        private $msg_errors = [
            'empty'     => 'Champ obligatoire !',
            'alpha' => 'Seul les majuscules, minuscules et caratères accentués acceptés !',
            'email'      => 'Format invalide (norme RFC2822) !',
            'password'  => 'Doit contenir au minimum 8 caratères, un caratères majuscule et minuscule, un chiffre, et un caratères spéciaux !?:_\-*#&%+',
            'exist'     => 'Email déja utilisé !',
            'not_equal'     => 'Les mots de passes ne sont pas identique !'
        ];

        protected string $layout = 'auth';

        /**
         * @return string
         */
        public function signin(): string
        {
            $email = (isset($_POST['mail'])) ? $_POST['mail'] : '';
            $password = (isset($_POST['password'])) ? $_POST['password'] : '';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $user = new UserModel();
                $user->setEmail($email);
                $password = Security::sanitize($password);

            }

            return $this->render('Auth.signin', []);

        }

        /**
         * @return string
         */
        public function signup(): string
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $nom = (isset($_POST['nom'])) ? $_POST['nom'] : '';
                $prenom = (isset($_POST['prenom'])) ? $_POST['prenom'] : '';
                $email = (isset($_POST['mail'])) ? $_POST['mail'] : '';
                $password = (isset($_POST['password'])) ? $_POST['password'] : '';
                $pwd_confirm = (isset($_POST['password_confirm'])) ? $_POST['password_confirm'] : '';

                if ($password !== $pwd_confirm && !isset($errors['password'])) $errors['password'] = $this->msg_errors['not_equal'];

                $user = new UserModel();
                $user->setNom($nom)
                    ->setPrenom($prenom)
                    ->setEmail($email)
                    ->hashPassword($password);
                $pwd_confirm = Security::sanitize($_POST['password_confirm']);

                $userDao = new UserDao();
                if (empty($errors) && $userDao->save($user)) {

                    AuthConnect::connect([ 'email' => $user->email, 'username' => $user->nom, /*'last_connect' =>
                        $user->getLastConnectFr()*/]);
                    /*MessageFlash::create('Connecté',$type = 'valide');*/

                    header('Location: /');
                    exit;
                }


            }
            return $this->render('Account.signup', [$errors]);

        }

        /**
         * @return void
         */
        public function signout()
        {

        }
    }
