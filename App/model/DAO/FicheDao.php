<?php

    namespace Cineflix\App\Model\DAO;

    use Cineflix\App\AppController;
    use Cineflix\App\Model\FicheModel;
    use Cineflix\App\Model\MovieModel;
    use Cineflix\Core\Database\Database;

    class FicheDao
    {
        private Database $db;
        public function __construct() {
            $this->db = AppController::$_Database;
        }
        public function findBy(string $item, mixed $value, bool $model = true)
        {
            $model = (true === $model) ? FicheModel::class : $model;

            switch($item) {
                case 'nom':
                    $clause = 'nom LIKE :nom';
                    break;
                case 'id':
                default:
                    $item = 'id';
                    $clause = 'id LIKE :id';
            }

            $query = "SELECT f.id AS id, f.nom AS nom, f.cinopsys AS cinopsys,
                    f.affiche AS affiche, f.date_sortie AS date_sortie, f.slug AS slug
                    FROM fiche AS f
                    WHERE f.$clause";

            $binvalue[] = ['col' => $item, 'val' => $value];
            $req = $this->db->prepare($query, $binvalue);



        }

        /**
         * Fonction pour les champs de recherche
         * @param $name
         *
         * @return array => FicheModel
         */
        public function searchFilmByName($name) {

            $clause = 'nom LIKE :nom';

            $query = "SELECT
                        fiche.*,
                        film.fiche_id AS film_id
                        FROM fiche
                        LEFT JOIN film ON fiche.id = film.fiche_id WHERE $clause";

            $binvalue[] = ['col' => 'nom', 'val' => $name.'%'];
            $req = $this->db->prepare($query, $binvalue);

            $results = $req->fetchAll(FicheModel::class);

            // TODO Format le timestamp en Y-m-d à modifier en d-m-Y et modifier le format des inputs date
            foreach ($results as $movie) {
                $movie->date_sortie = date('Y-m-d', strtotime($movie->date_sortie));
            }

            return $results;
        }
    }