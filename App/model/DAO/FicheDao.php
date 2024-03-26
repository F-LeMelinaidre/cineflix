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

            return $req->fetch($model);

        }
        // function find Ajax pour l'input modifier la precedante et ajouter un innert join de film
    }