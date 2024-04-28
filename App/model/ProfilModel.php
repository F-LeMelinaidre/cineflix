<?php

    namespace Cineflix\App\Model;

    use Cineflix\Core\Util\Regex;
    use Cineflix\Core\Util\Security;

    class ProfilModel extends AbstractModel
    {
        private string $table = 'profil';
        public ?string $prenom = null;
        public ?string $date_naissance = null;
        public ?string $numero_voie = null;
        public ?string $type_voie = null;
        public ?string $nom_voie = null;
        public ?int $code_postale = null;
        public ?string $ville = null;
        public ?int $point = null;

        public UserModel $user;

        /**
         * @param array|null $data
         */
        public function __construct(array $data = null)
        {
            parent::__construct($data);

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

            if(isset($data['user_id'])) $this->id = $data['user_id'];

            if(isset($data['nom'])) {
                $this->nom = $data['nom'];
                unset($data['nom']);
            }

            if(isset($data['prenom'])) {
                $this->prenom = $data['prenom'];
                unset($data['prenom']);
            }

            if(isset($data['date_naissance'])) {
                $this->date_naissance = $data['date_naissance'];
                unset($data['date_naissance']);
            }

            if(isset($data['numero_voie'])) {
                $this->numero_voie = $data['numero_voie'];
                unset($data['numero_voie']);
            }

            if(isset($data['type_voie'])) {
                $this->type_voie = $data['type_voie'];
                unset($data['type_voie']);
            }

            if(isset($data['nom_voie'])) {
                $this->nom_voie = $data['nom_voie'];
                unset($data['nom_voie']);
            }

            if(isset($data['code_postale'])) {
                $this->code_postale = $data['code_postale'];
                unset($data['code_postale']);
            }

            if(isset($data['ville'])) {
                $this->ville = $data['ville'];
                unset($data['ville']);
            }

            if(isset($data['point'])) {
                $this->point = $data['point'];
                unset($data['point']);
            }

            $user = [];
            if(!empty($data)) {
                foreach ($data as $col => $val) {
                    $parts = explode('_', $col);
                    if($parts[0] === 'user') {
                        $user[$parts[1]] = $val;
                    }
                }
            }


            if(!empty($user)) {
                $this->user = new UserModel($user);
            }
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
         * @return string
         */
        public function getDateNaissance(): string
        {
            return !empty($this->date_naissance)? date("d-m-Y", strtotime($this->date_naissance)) : '';
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
        public function getAddress(): string
        {
            return $this->numero_voie. ' ' .$this->type_voie. ' ' .$this->nom_voie;
        }

        /**
         * @param array $data
         *
         * @return void
         */
        public function addUser(array $data = null): void
        {
            $this->user = new UserModel($data);
        }


    }