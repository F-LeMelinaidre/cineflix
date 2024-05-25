<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\DAO\List\StatusFilm;
    use Cineflix\App\Model\FilmModel;
    use Cineflix\Core\Util\MessageFlash;

    class FilmDao extends AbstractDAO
    {

        public function findOneBy(string $col, string $val, array $options = [], $format = 'model'): mixed
        {
            $result = parent::findOneBy($col, $val, $options, $format);

            return $result;
        }

        public function findAll(array $options = [], string $format = 'model')
        {
            $movies = parent::findAll($options, $format);

            $movie_to_update_status = [];

            foreach($movies as $movie) {

                if ($movie->exploitation && $movie->exploitation->fin < date('Y-m-d')) {

                    $movie->setStatus(0);
                    //TODO
                    $movie_to_update_status[] = $movie;
                }
            }

            return $movies;
        }

        /**
         * @param FilmModel $movie
         *
         * @return void
         */
        public function create(object $movie)
        {

            try {

                $this->db->beginTransaction();

                $movie_data = [
                    'nom'           => $movie->nom,
                    'synopsis'      => $movie->synopsis,
                    'date_sortie'   => $movie->date_sortie,
                    'status'        => $movie->status_id,
                    'slug'          => $movie->getSlug(),
                ];

                if($movie->status === StatusFilm::EN_SALLE){

                    if(is_null($movie->cinema->ville->id)) {

                        $ville_data = [
                            'nom' => $movie->cinema->ville->nom
                        ];
                        $this->db->insert('ville', $ville_data);
                        $movie->cinema->ville->setId($this->db->getLastInsertId());
                    }

                    if(is_null($movie->cinema->id)) {
                        $cinema_data = [
                            'nom' => $movie->cinema->nom,
                            'ville_id' => $movie->cinema->ville->id
                        ];

                        $this->db->insert('cinema', $cinema_data);
                        $movie->cinema->setId($this->db->getLastInsertId());

                    }

                    $movie_data['cinema_id'] = $movie->cinema->id;
                }


                $this->db->insert($this->table,$movie_data);
                $this->last_id = $this->db->getLastInsertId();


                if($movie->status === StatusFilm::EN_SALLE) {
                    $exploitation = [
                        'film_id' => $this->last_id,
                        'debut'   => $movie->exploitation->debut,
                        'fin'     => $movie->exploitation->fin,
                    ];
                    $this->db->insert('exploitation' ,$exploitation);
                }






                $this->db->commit();

                $result = true;

            } catch (\PDOException $e) {
                $result = false;

                $this->db->rollback();

                MessageFlash::create("PDOException: " . $e->getMessage(),'erreur');
            }


            return $result;

        }

        private function getVille()
        {

        }

    }