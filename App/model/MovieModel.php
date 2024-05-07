<?php

    namespace Cineflix\App\Model;

    use Attribute;
    use Cineflix\App\DAO\List\StatusMovie;
    use Normalizer;
    use PHPUnit\Util\Json;

    class MovieModel extends AbstractModel
    {

        private int $status = 0;
        private ?string $synopsis;
        private ?string $affiche;
        private ?string $date_sortie;
        private ?CinemaModel $cinema = null;
        private ?ExploitationModel $exploitation = null;
        private string $slug = '';


        /**
         * @param array|null $data
         */
        public function __construct(?array $data = null)
        {
            parent::__construct($data);

            if(isset($data['status'])) $this->status = $data['status'];

            if(isset($data['synopsis'])) $this->synopsis = $data['synopsis'];

            if(isset($data['affiche'])) $this->affiche = $data['affiche'];

            if(isset($data['date_sortie'])) $this->date_sortie = $data['date_sortie'];

            if(isset($data['slug'])) $this->slug = $data['slug'];

            if(isset($data['ville']) && isset($data['cinema'])) $data['cinema']['ville'] = $data['ville'];

            if(isset($data['cinema'])) $this->cinema = new CinemaModel($data['cinema']);
            if(isset($data['exploitation'])) $this->exploitation = new ExploitationModel($data['exploitation']);
        }

        public function __get(string $item): mixed
        {

            switch($item) {
                case 'status':
                case 'synopsis':
                case 'affiche':
                case 'date_sortie':
                case 'slug':
                case'cinema':
                case 'exploitation':
                    $item = $this->$item;
                    break;
                default:
                    $item = parent::__get($item);
                    break;
            }

            return $item;
        }
        public function setNom(string $nom): void
        {
            parent::setNom($nom);

            $this->setSlug($nom);
        }

        public function setStatus(string $status): void
        {
            $this->status = StatusMovie::getStatus($status);
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

        public function setSlug(string $slug): void
        {
            // remplace les caratère accentué par leur equivalant non accentué
            // Activer l'extention intl de PHP
            // Parametrer la lib dans composer.json "ext-intl": "*"
            $normalized =  Normalizer::normalize($slug, Normalizer::FORM_D);
            $slug = preg_replace('/\p{Mn}/u', '', $normalized);
            // Remplace les caratère spéciaux par un -
            $slug = preg_replace('/[^\p{L}\p{N}]/u', '-', $slug);
            // supprime les doubles --
            $slug = preg_replace('/-{2,}/', '-', $slug);
            // supprime les - en debut et fin de chaine
            $slug = trim($slug, '-');
            $this->slug = str_replace(' ', '-', ucfirst($slug));
        }

    }
