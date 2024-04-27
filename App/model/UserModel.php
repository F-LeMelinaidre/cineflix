<?php

    namespace Cineflix\App\Model;

    use Cineflix\Core\Util\Security;

    class UserModel extends AbstractModel
    {

        protected ProfilModel $profil;
        protected ?string $password = null;
        protected ?string $password_confirm = null;

        public ?string $email = null;
        public string $token;
        public int $admin = 0;
        public string $connect;
        public string $last_connect;

        /**
         * @param array|null $data
         */
        public function __construct(array $data = null)
        {
            parent::__construct($data);

            if(isset($data['email'])) $this->email = $data['email'];
            if(isset($data['created'])) $this->created = $this->getDateFr($data['created']);
            if(isset($data['modified'])) $this->modified = $this->getDateFr($data['modified']);
            if(isset($data['connect'])) $this->connect = $this->getDateFr($data['connect']);
            if(isset($data['last_connect'])) $this->last_connect = $this->getDateFr($data['last_connect']);

            if(isset($data['profil'])) $this->setProfil($data['profil']);
        }

        /**
         * @param string $email
         *
         * @return void
         */
        public function setEmail(string $email): void
        {
            $this->email = Security::sanitize($email);
        }

        /**
         * @param string $password
         *
         * @return void
         */
        public function setPassword(string $password): void
        {
            $this->password = Security::sanitize($password);
        }

        /**
         * @return string
         */
        public function getPassword(): ?string
        {
            return $this->password;
        }

        /**
         * @param string $password
         *
         * @return void
         */
        public function setPasswordConfirm(string $password): void
        {
            $this->password_confirm = Security::sanitize($password);
        }

        /**
         * @param string $password
         *
         * @return void
         */
        public function getPasswordConfirm(): ?string
        {
            return $this->password_confirm;
        }

        /**
         * @param $password
         *
         * @return string
         */
        public function getHashPassword(): string
        {
            return password_hash($this->password, PASSWORD_BCRYPT);
        }

        /**
         * @param array $data
         *
         * @return void
         */
        public function setProfil(object $profil): void
        {
            $this->profil = $profil;
        }

        /**
         * @return ProfilModel
         */
        public function getProfil(): ProfilModel
        {
            return $this->profil;
        }

        /**
         * @param array|null $data
         *
         * @return void
         */
        public function hydrate(array $data = null)
        {
            parent::hydrate($data);

            if(isset($data['email'])) $this->email = $data['email'];
            if(isset($data['created'])) $this->created = $this->getDateFr($data['created']);
            if(isset($data['modified'])) $this->modified = $this->getDateFr($data['modified']);
            if(isset($data['connect'])) $this->connect = $this->getDateFr($data['connect']);
            if(isset($data['last_connect'])) $this->last_connect = $this->getDateFr($data['last_connect']);

            if(isset($data['profil'])) $this->setProfil($data['profil']);
        }

    }