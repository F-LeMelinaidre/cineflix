<?php
    //wKV4d:G-i!3Z
    namespace Cineflix\App\Model;

    use Cineflix\App\DAO\List\Role;
    use Cineflix\Core\Util\Security;

    class UserModel extends AbstractModel
    {
        private int $role;
        private ProfilModel $profil;

        protected ?string $email = null;
        protected ?string $password_hash = null;
        protected ?string $password = null;
        protected ?string $password_confirm = null;
        protected string $token;
        protected string $connect;
        protected string $last_connect;



        /**
         * @param array|null $data
         */
        public function __construct(?array $data = null)
        {
            parent::__construct($data);

            $this->role = Role::ADHERENT->value;

            $this->hydrate($data);

        }

        /**
         * @param array|null $data
         *
         * @return void
         */
        public function hydrate(array $data = null)
        {
            parent::hydrate($data);

            if(isset($data['role'])) $this->setRole($data['role']);

            if(isset($data['email'])) $this->setEmail($data['email']);

            if(isset($data['connect'])) $this->setConnect($data['connect']);

            if(isset($data['last_connect'])) $this->setLast_connect($data['last_connect']);

            $profil = (isset($data['profil'])) ? $data['profil'] : [];

            $this->profil = new ProfilModel($profil);
        }

        public function __get($item): mixed
        {
            switch($item) {
                case 'email':
                case 'password_hash':
                case 'profil':
                case 'role':
                    $item = $this->$item;
                    break;
                case 'role_name':
                    $item = Role::toString($this->role);
                    break;
                case 'last_connect_fr':
                    $item = $this->getDateHeureFr($this->last_connect);
                    break;

                case 'connect_fr':
                    $item = $this->getDateHeureFr($this->connect);

                default:
                    $item = parent::__get($item);
                    break;
            }
            return $item;
        }
        /**
         * @param int $role
         *
         * @return void
         */
        public function setRole(int $role): void
        {
            $this->role = Security::sanitize($role);
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
            if(!empty($password)) {
                $this->password = Security::sanitize($password);
                $this->password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            }

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


    }