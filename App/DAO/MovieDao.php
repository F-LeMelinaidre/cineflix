<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\Controller\Movie;
    use Cineflix\App\DAO\List\StatusMovie;
    use Cineflix\App\Model\MovieModel;

    class MovieDao extends AbstractDAO
    {

        public function findOneBy(string $col, string $val, array $options = null): mixed
        {
            $result = parent::findOneBy($col, $val, $options);
            return new MovieModel($result);
        }

        /**
         * @param MovieModel $movie
         * @return void
         */
        public function create(object $movie): void
        {
            try {

                //$this->db->beginTransaction();



                //$this->db->insert($this->table,$user_data);

                /*if($movie->status === StatusMovie::EN_SALLE) {

                    $this->last_id = $this->db->getLastInsertId();

                    $profil_data = [
                        'user_id'   => $this->last_id,
                        'nom'       => $user->profil->nom,
                        'prenom'    => $user->profil->prenom
                    ];

                    $this->db->insert('profil' ,$profil_data);

                }*/


                //$this->db->commit();

                $result = true;

            } catch (\PDOException $e) {
                $result = false;

                //$this->db->rollback();

                echo "PDOException: " . $e->getMessage();
            }
            /*var_dump($movie);
            die();*/

            //return $result;

        }

    }