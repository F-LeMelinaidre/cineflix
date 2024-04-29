<?php

    namespace Cineflix\App\Model;

    use Normalizer;

    class MovieModel extends AbstractModel
    {

        public int $status = 0;

        public ?string $synopsis;
        public ?string $affiche;
        public ?string $date_sortie;
        public ?CinemaModel $cinema = null;
        public ?ExploitationModel $exploitation = null;
        private string $slug = '';


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


            if(!empty($data)) {
                // les cle doivent etre configurer pour faire en sorte qu'elles
                // coincide avec les relations de tables
                // cinema => ville  =  cinema_ville
                // * la methode select() class Database ajoute par defaut AS "table_colonne" pour les
                // jointure de premier niveau
                // si la table liée est elle même jointe ajouter manuellement dans le select
                // exemple AS cinema_ville_"nom de la colonne"
                $prefix_list = ['cinema', 'exploitation'];
                foreach ($data as $key => $val) {

                    foreach ($prefix_list as $prefix) {

                        if (strpos($key, $prefix . '_') === 0) {

                            $unprefixed_key = substr($key, strlen($prefix) + 1);

                            $data[$prefix][$unprefixed_key] = $val;
                            unset($data[$key]);
                        }
                    }
                }
            }
            if(isset($data['cinema'])) $this->cinema = new CinemaModel($data['cinema']);
            if(isset($data['exploitation'])) $this->exploitation = new ExploitationModel($data['exploitation']);
        }

        public function setNom(string $nom): void
        {
            parent::setNom($nom);

            $this->setSlug($nom);
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

        public function getSlug(): string
        {
            return $this->slug;
        }


    }
