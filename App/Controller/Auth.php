<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\Model\AccountModel;
    use Cineflix\App\Model\DAO\UserDao;
    use Cineflix\App\Model\UserModel;
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

                $data['nom'] = Security::sanitize($_POST['nom']);
                $data['prenom'] = Security::sanitize($_POST['prenom']);
                $data['mail'] = Security::sanitize($_POST['mail']);
                $data['password'] = Security::sanitize($_POST['password']);
                $password_confirm = Security::sanitize($_POST['password_confirm']);

                foreach($data as $key => $val) {
                    if (empty($val)) $errors[$key] = $this->msg_errors['empty'];

                    if ('nom' === $key || 'prenom' === $key) {

                        if (!preg_match(Regex::getPattern('carateres'), $val)) $errors[$key] = $this->msg_errors['carateres'];

                    } elseif(!preg_match(Regex::getPattern($key), $val)) {
                        $errors[$key] = $this->msg_errors[$key];
                    }
                }


                $userDao = new UserDao();
                if ($userDao->isExist($data['mail'])) $errors['mail'] = $this->msg_errors['exist'];

                if ($data['password'] !== $password_confirm && !isset($errors['password'])) $errors['password'] = $this->msg_errors['not_equal'];


                if (!isset($errors) && $userDao->save($data)) {
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
