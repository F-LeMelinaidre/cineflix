<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\Model\AccountModel;
    use Cineflix\Core\AbstractController;

    class Auth extends AbstractController
    {

        protected string $layout = 'auth';

        public function signin(): string
        {

            return $this->render('Auth.signin', []);

        }

        public function signup(): string
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {

                var_dump($_POST);

                $user = new AccountModel();

                $user->setLastName($_POST['nom']);
                $user->setFirstName($_POST['prenom']);
                $user->setMail($_POST['mail']);
                $user->setPassword($_POST['password'], $_POST['password_confirm']);

                if($user->isValid()) {
                    echo 'rec';
                }
            }
            return $this->render('Account.signup', []);

        }

        public function signout()
        {

        }
    }
