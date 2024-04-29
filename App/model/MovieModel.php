<?php

    namespace Cineflix\App\Model;


    class MovieModel extends AbstractModel
    {

        public int $status = 0;

        public ?string $synopsis;
        public ?string $affiche;
        public ?string $date_sortie;
        public ?CinemaModel $cinema = null;
        public ?string $slug;


        /**
         * @param array|null $data
         */
        public function __construct(?array $data = null)
        {
            parent::__construct($data);

            if(isset($data['status'])) {
                $this->status = $data['status'];
                unset($data['status']);
            }
            if(isset($data['synopsis'])) {
                $this->synopsis = $data['synopsis'];
                unset($data['synopsis']);
            }
            if(isset($data['affiche'])) {
                $this->affiche = $data['affiche'];
                unset($data['affiche']);
            }
            if(isset($data['date_sortie'])) {
                $this->date_sortie = $data['date_sortie'];
                unset($data['date_sortie']);
            }
            if(isset($data['slug'])) {
                $this->slug = $data['slug'];
                unset($data['slug']);
            }

            $cinema = [];
            if(!empty($data)) {
                foreach ($data as $col => $val) {
                    $parts = explode('_', $col);
                    if($parts[0] === 'cinema') {
                        $cinema[$parts[1]] = $val;
                    } else {
                        $cinema[$col] = $val;
                    }
                }
            }
            if(!empty($cinema)) $this->cinema = new CinemaModel($cinema);

        }

        public function setName(string $nom): void
        {
            parent::setNom($nom);
            $this->slug = str_replace([' ',"'"],'-',$this->nom);
        }

        /**
         * @param string $date
         * @return void
         */
        public function setDateSortie(string $date): void
        {
            $this->date_sortie = $date;
        }

        public function setSynopsis(string $synopsis): void
        {
            $this->synopsis = $synopsis;
        }

        public function setAffiche(string $affiche): void
        {

        }


    }
