<?php

    namespace Cineflix\App\Model;

    use Cineflix\App\AppController;
    use Cineflix\App\DAO\List\StatusFilm;
    use Cineflix\Core\Util\Security;

    class FilmModel extends AbstractModel
    {

        private StatusFilm $status = StatusFilm::EN_SALLE;
        private ?CinemaModel $cinema = null;
        private ?ExploitationModel $exploitation = null;

        protected ?string $affiche;
        protected ?string $synopsis;
        protected ?int $status_id;
        protected ?string $date_sortie;

        /**
         * @param array|null $data
         */
        public function __construct(?array $data = null)
        {
            parent::__construct($data);

            $this->hydrate($data);


        }

        public function hydrate(array $data = null)
        {
            parent::hydrate($data);

            if (!empty($data['exploitation'])) $this->exploitation = new ExploitationModel($data['exploitation']);

            if(isset($data['status'])) $this->setStatus($data['status']);

            if(isset($data['synopsis'])) $this->setSynopsis($data['synopsis']);

            if(isset($data['affiche'])) $this->setAffiche($data['affiche']);

            if(isset($data['date_sortie'])) $this->setDateSortie($data['date_sortie']);

            if(isset($data['slug'])) $this->setSlug($data['slug']);

            if(isset($data['ville']) && isset($data['cinema'])) $data['cinema']['ville'] = $data['ville'];
            if (!empty($data['cinema'])) $this->cinema = new CinemaModel($data['cinema']);


            /*if (!empty($this->status === StatusFilm::EN_SALLE)) {

                $db = AppController::$_Database;
                $exploitations = $db->select('*')
                    ->from('exploitation')
                    ->where('exploitation.film_id = :film_id')
                    ->setParameter('film_id', $this->id)
                    ->fetchAll();

                foreach ($exploitations as $exploitation) {
                    $this->exploitations[] = new ExploitationModel($exploitation);
                }
            }*/
        }

        public function __get(string $item): mixed
        {
            switch ($item) {
                case 'synopsis':
                case 'affiche':
                case 'cinema':
                case 'exploitation':
                case 'status':
                case 'status_id':
                    $item = $this->$item;
                    break;

                case 'date_sortie_fr':
                    $item = $this->getDateFr($this->date_sortie);
                    break;

                default:
                    $item = parent::__get($item);
                    break;
            }
            return  $item;
        }

        public function setStatus($status): void
        {
            if (is_string($status)) {
                $this->status = StatusFilm::getStatusByName($status);
            } elseif(is_int($status)) {
                $this->status = StatusFilm::getStatusById($status);
            }elseif($status instanceof StatusFilm) {
                    $this->status = $status;
            }

            if( $this->status === StatusFilm::EN_SALLE && $this->exploitation) {
                if($this->exploitation->isSoon()) {
                    $this->status = StatusFilm::PROCHAINEMENT_EN_SALLE;
                }

                if($this->exploitation->soonCancelled()) {
                    $this->status = StatusFilm::BIENTOT_DEPROGRAMME;
                }

            }
            $this->status_id = $this->status->value;
        }

        /**
         * @param string $date
         * @return void
         */
        public function setDateSortie(string $date): void
        {
            $this->date_sortie = Security::sanitize($date);
        }

        public function setSynopsis(string $synopsis): void
        {
            $this->synopsis = Security::sanitize($synopsis);
        }

        public function setAffiche(string $affiche): void
        {
            $this->affiche = Security::sanitize($affiche);
        }

        public function getColorText() {
            switch ($this->status) {
                case StatusFilm::EN_SALLE :
                    $css = 'en-salle-txt';
                    break;
                case StatusFilm::EN_STREAMING :
                    $css = 'en-streaming-txt';
                    break;
                case StatusFilm::PROCHAINEMENT_EN_SALLE :
                    $css = 'bientot-txt';
                    break;
                case StatusFilm::PROCHAINEMENT_EN_STREAMING :
                    $css = 'bientot-txt';
                    break;
                case StatusFilm::BIENTOT_DEPROGRAMME :
                    $css = 'text-warning';
                    break;
                case StatusFilm::INDISPONIBLE :
                default:
                    $css = 'text-danger';
                    break;

            }

            return $css;
        }

    }
