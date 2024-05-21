<?php

    namespace Cineflix\App\Model;

    use Cineflix\App\Controller\Admin\User;
    use Cineflix\Core\Util\Security;

    class ProfilModel extends AbstractModel
    {
        private string $table = 'profil';
        private UserModel $user;

        protected ?string $prenom = null;
        protected ?string $date_naissance = null;
        protected ?string $numero_voie = null;
        protected ?string $type_voie = null;
        protected ?string $nom_voie = null;
        protected ?int $code_postale = null;
        protected ?string $ville = null;
        protected ?int $point = null;


        /**
         * @param array|null $data
         */
        public function __construct(?array $data = null)
        {
            parent::__construct($data);

            if (isset($data['user_id'])) $this->id = $data['user_id'];

            if (isset($data['nom'])) $this->nom = $data['nom'];

            if (isset($data['prenom'])) $this->prenom = $data['prenom'];

            if (isset($data['date_naissance'])) $this->date_naissance = $data['date_naissance'];

            if (isset($data['numero_voie'])) $this->numero_voie = $data['numero_voie'];

            if (isset($data['type_voie'])) $this->type_voie = $data['type_voie'];

            if (isset($data['nom_voie'])) $this->nom_voie = $data['nom_voie'];

            if (isset($data['code_postale'])) $this->code_postale = $data['code_postale'];

            if (isset($data['ville'])) $this->ville = $data['ville'];

            if (isset($data['point'])) $this->point = $data['point'];

            if (isset($data['user'])) $this->user = new UserModel($data['user']);
        }

        /**
         * @param string $item
         *
         * @return mixed
         */
        public function __get(string $item): mixed
        {
            switch($item) {
                case 'nom':
                case 'prenom':
                case 'date_naissance':
                case 'numero_voie':
                case 'type_voie':
                case 'nom_voie':
                case 'code_postale':
                case 'ville':
                case 'point':
                case 'user':
                    $item = $this->$item;
                    break;

                case 'user_id':
                    $item = $this->id;
                    break;

                case 'date_naissance_fr':
                    $item = (!is_null($this->date_naissance)) ? $this->getDateFr($this->date_naissance) : '';
                    break;

                case 'adresse':
                    $item = $this->getAddress();
                    break;

                default:
                    $item = parent::__get($item);
                    break;
            }

            return $item;
        }
        /**
         * @param string $prenom
         *
         * @return $this
         */
        public function setPrenom(string $prenom): void
        {
            $this->prenom = ucfirst(Security::sanitize($prenom));
        }

        /**
         * @param string $date
         *
         * @return void
         */
        public function setDateNaissance(string $date): void
        {
            $this->date_naissance = Security::sanitize($date);
        }

        /**
         * @param string $n_voie
         *
         * @return void
         */
        public function setNumeroVoie(string $n_voie): void
        {
            $this->numero_voie = Security::sanitize($n_voie);
        }

        /**
         * @param string $type
         *
         * @return void
         */
        public function setTypeVoie(string $type): void
        {
            $this->type_voie = Security::sanitize($type);
        }

        /**
         * @param string $nom_voie
         *
         * @return void
         */
        public function setNomVoie(string $nom_voie): void
        {
            $this->nom_voie = Security::sanitize($nom_voie);
        }

        /**
         * @param int $cp
         *
         * @return void
         */
        public function setCodePostale(int $cp): void
        {
            $this->code_postale = (0 != $cp)? Security::sanitize($cp) : null;
        }

        /**
         * @param string $ville
         *
         * @return void
         */
        public function setVille(string $ville): void
        {
            $this->ville = Security::sanitize($ville);
        }

        /**
         * @return string
         */
        private function getAddress(): string
        {
            return $this->numero_voie. ' ' .$this->type_voie. ' ' .$this->nom_voie;
        }

    }