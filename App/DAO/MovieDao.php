<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\Model\MovieModel;

    class MovieDao extends AbstractDAO
    {

        public function findAll(array $options = null)
        {

            $result = $this->db->select('movie.*','cinema.nom', 'ville.id', 'ville.nom')
                ->from($this->table)
                ->join('cinema','LEFT','cinema.id = movie.cinema_id')
                ->join('ville', 'LEFT', 'ville.id = cinema.ville_id')
                ->order('movie.modified')
                ->fetchall();

            //$keys = ['cinema','ville'];
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
         * @param string $status
         * @param array|null $options
         * @return array
         */
        public function findAllByStatus(string $status, array $options = null): array
        {


            return [];

            //return parent::findAllBy($params,$options);
        }

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

            var_dump($movie);
            die();
        }

    }