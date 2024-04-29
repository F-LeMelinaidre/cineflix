<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\DAO\List\StatusMovie;
    use Cineflix\App\Model\MovieModel;

    class MovieDao extends AbstractDAO
    {

        public function findAll(array $options = null)
        {

            $result = parent::findAll($options);

            foreach($result as $k => $movie) {
                $result[$k] = new MovieModel($movie);
            }
            return $result;
        }

        /**
         * Création de sous tableau recurcivement en fonction des clés
         * le prefixage des clés représante les relations en profondeur entre les tables
         * parent_enfant_petitEnfant => valeur
         * @param array $data
         * @param array $keys // tableau des tables
         *
         * @return array
         */
        /*private function mapping(array $data, array $keys): array
        {
            $result = [];

            foreach ($data as $key => $value) {
                $parts = explode('_', $key, 2);
                //recupère le prefix
                $prefix = $parts[0];
                //supprime le prefix du nom de la colonne
                $unprefixed_key = $parts[1] ?? '';

                //si il y a correspondance entre le prefix et le tableau des tables
                if (in_array($prefix, $keys)) {

                    //on créé un sous tableau
                    $sub_data = [$unprefixed_key => $value];

                    //si la clé est encore prefixé on appel de nouveau la methode pour creer une autre sous tableau
                    if (strpos($unprefixed_key, '_') !== false) {
                        $sub_data = $this->mapping($sub_data, $keys);
                    }

                    // si le parent a deja un sous tableau indexé par le prefix
                    // on fusionne celui ci avec la nouvelle paire clé valeur issu du meme prefix
                    if (isset($result[$prefix])) {
                        $result[$prefix] = array_merge($result[$prefix], $sub_data);
                    } else {
                        // sinon on ajoute le sous tableau indéxé par le prefix au tableau parent
                        $result[$prefix] = $sub_data;
                    }

                } else {
                    // si la cle ne contient pas de prefixe
                    $result[$key] = $value;
                }
            }
            return $result;
        }*/

        /**
         * @param string $item
         * @param mixed $value
         * @return mixed|null
         */
        public function findBy(string $item, mixed $value)
        {
            /*$model = MovieModel::class;

            switch($item) {
                case 'slug':
                    $clause = 'slug LIKE :slug';
                    break;
                case 'id':
                default:
                    $item = 'id';
                    $clause = 'id LIKE :id';
            }

            $query = "SELECT *
                      FROM movie AS film
                      WHERE film.$clause";

            $binvalue[] = ['col' => $item, 'val' => $value];
            $req = $this->db->prepare($query, $binvalue);

            return $req->fetch(MovieModel::class)*/;

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