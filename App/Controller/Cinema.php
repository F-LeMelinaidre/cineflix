<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\DAO\List\StatusMovie;
    use Cineflix\App\DAO\MovieDao;
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
        public function movieSearch(string $ajax): void
        {
            //supprime le 1er caratère => ?
            $ajax = substr($ajax,1);

            $parts = explode('=', $ajax);

            $col = Security::sanitize($parts[0]);
            $val = Security::sanitize($parts[1]);

            $options = [
                'select' => ['movie.*','cinema.nom','ville.nom','exploitation.debut','exploitation.fin'],
                'where'  => ["movie.$col LIKE :$col"],
                'params' => [$col => '%'.urldecode($val).'%'],
                'contain' => [
                    'cinema' => 'cinema.id = movie.cinema_id',
                    'ville'  => 'ville.id = cinema.ville_id',
                    'exploitation' => 'exploitation.movie_id = movie.id']
            ];

            $movieDao = new MovieDao();
            $movies = $movieDao->findAll($options,'Json');
            $status = json_encode(StatusMovie::statusToArray());

            $json = '{"movies":'.$movies.', "movieStatus":'.$status.'}';

            // Afficher le JSON
            echo $json;
        }

    }
