<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\DAO\List\StatusMovie;
    use Cineflix\App\DAO\MovieDao;
    use Cineflix\App\DAO\SeanceDao;
    use Cineflix\Core\AbstractController;
    use Cineflix\Core\Util\Security;

    class Movie extends AbstractController
    {
        protected MovieDao $movieDao;

        public function index(?string $status = null): string
        {
            $status_id = (!is_null($status)) ? StatusMovie::getStatus($status) : StatusMovie::EN_SALLE->value;

            $options = [
                'select'  => ['*','cinema.nom','ville.nom'],
                'where'  => ['movie.status = :status'],
                'params' => ['status' => $status_id],
                'contain' => [
                    'cinema' => 'cinema.id = movie.cinema_id',
                    'ville'  => 'ville.id = cinema.ville_id'],
                'order'  => 'movie.modified'
            ];

            $movieDao = new MovieDao();
            $movies = $movieDao->findAll($options);

            return $this->render('Movie.index',compact('movies', 'status_id'));
        }

        public function show(string $slug): string
        {
            $movieDao = new MovieDao();
            $options = [
                'select'  => ['*','cinema.nom','ville.nom'],
                'contain' => [
                    'cinema' => 'cinema.id = movie.cinema_id',
                    'ville'  => 'ville.id = cinema.ville_id'],
            ];
            $movie = $movieDao->findOneBy('slug', $slug, $options);

            $this->title_page .= ' | ' . ucfirst($movie->nom);

            $seanceDao = new SeanceDao();
            $options = [
                'select'  => ['*'],
                'where'  => ['seance.movie_id = :movie_id'],
                'params' => ['movie_id' => $movie->id],
                'order'  => 'seance.date'
            ];

            $seances = $seanceDao->findAll($options);

            $nb_seances = count($seances) - 1;
            $seances = array_chunk($seances, 3);

            return $this->render('Movie.show', compact('movie', 'seances', 'nb_seances'));
        }

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
