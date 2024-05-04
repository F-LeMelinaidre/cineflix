<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\DAO\List\StatusMovie;
    use Cineflix\App\DAO\MovieDao;
    use Cineflix\App\DAO\SeanceDao;
    use Cineflix\Core\AbstractController;

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
            $options = [
                'select'  => ['*','cinema.nom','ville.nom'],
                'where'  => ['movie.slug = :slug'],
                'params' => ['slug' => $slug],
                'contain' => [
                    'cinema' => 'cinema.id = movie.cinema_id',
                    'ville'  => 'ville.id = cinema.ville_id'],
            ];
            $movieDao = new MovieDao();
            $movie = $movieDao->findOneBy('slug', $slug, $options);
            //$this->title_page .= ' | ' . ucfirst($movie->nom);
            //$seanceDao = new SeanceDao();
            //$seances = $seanceDao->findAllFromMovie($movie->movie_id);
            $seances = [];

            return $this->render('Movie.show', compact('movie', 'seances'));
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
            $params = array(
                'col' => $parts[0],
                'val' => $parts[1]
            );

            $options = [
                'select' => ['movie.*','cinema.nom','exploitation.debut','exploitation.fin','ville.nom AS cinema_ville_nom'],
                'where'  => ['m.'.$params['col'].' LIKE :'.$params['col']],
                'params' => [$params['col'] => '%'.$params['val'].'%'],
                'contain' => [
                    'cinema' => 'cinema.id = movie.cinema_id',
                    'exploitation' => 'exploitation.movie_id = movie.id',
                    'ville'  => 'ville.id = cinema.ville_id']
            ];

            $movieDao = new MovieDao();
            $movies = $movieDao->findAll($options);
            // Convertir le tableau PHP en format JSON
            $jsonData = json_encode($movies, JSON_PRETTY_PRINT);

            // Afficher le JSON
            echo $jsonData;
        }

    }
