<?php

    namespace Cineflix\App\Model;

    use Cineflix\Core\Util\Security;

    class AccountModel
    {

        public string $nom = '';
        public string $prenom;
        public string $mail;
        public string $password;

        public array $errors;

        public function __construct()
        {

        }



    }