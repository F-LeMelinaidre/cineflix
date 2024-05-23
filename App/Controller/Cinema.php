<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\DAO\List\StatusFilm;
    use Cineflix\App\DAO\FilmDao;
    use Cineflix\App\DAO\SeanceDao;
    use Cineflix\Core\AbstractController;
    use Cineflix\Core\Util\Security;

    class Cinema extends AbstractController
    {



        /**
         * @param string $ajax
         *
         * @return void
         */
        public function cinemaSearch(string $ajax): void
        {
            //supprime le 1er caratère => ?
            $ajax = substr($ajax,1);

            $parts = explode('=', $ajax);

            $col = Security::sanitize($parts[0]);
            $val = Security::sanitize($parts[1]);

            $options = [
                'select' => ['cinema.*', 'ville.nom'],
                'where'  => ["cinema.$col LIKE :$col"],
                'params' => [$col => '%'.urldecode($val).'%'],
                'contain' => ['ville'  => 'ville.id = cinema.ville_id']
            ];

            $json = $this->dao->findAll($options,'Json');

            // Afficher le JSON
            echo $json;
        }

        /**
         * @param string $ajax
         *
         * @return void
         */
        public function villeSearch(string $ajax): void
        {
            //supprime le 1er caratère => ?
            $ajax = substr($ajax,1);

            $parts = explode('=', $ajax);

            $col = Security::sanitize($parts[0]);
            $val = Security::sanitize($parts[1]);

            $options = [
                'table' => 'ville',
                'select' => ['ville.*'],
                'where'  => ["ville.$col LIKE :$col"],
                'params' => [$col => '%'.urldecode($val).'%'],
            ];
            $json = $this->dao->findAll($options,'Json');

            // Afficher le JSON
            echo $json;
        }

    }
