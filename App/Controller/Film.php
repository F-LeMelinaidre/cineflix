<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\DAO\List\StatusFilm;
    use Cineflix\App\DAO\FilmDao;
    use Cineflix\App\DAO\SeanceDao;
    use Cineflix\App\Model\FilmModel;
    use Cineflix\App\Model\SeanceModel;
    use Cineflix\Core\AbstractController;
    use Cineflix\Core\Util\MessageFlash;
    use Cineflix\Core\Util\Security;

    class Film extends AbstractController
    {
        protected FilmDao $filmDao;

        public function __construct()
        {
            parent::__construct();


        }

        public function index(?string $status = null): string
        {

            $status_id = (!is_null($status)) ? StatusFilm::getStatusId($status) : StatusFilm::EN_SALLE->value;

            $this->page_active = ($status_id !== StatusFilm::EN_STREAMING->value)? StatusFilm::EN_SALLE : StatusFilm::EN_STREAMING;

            $options = [
                'select'  => ['film.*','cinema.nom','ville.nom','exploitation.debut','exploitation.fin'],
                'where'  => ['film.status = :status'],
                'params' => ['status' => $status_id],
                'contain' => [
                    'cinema' => 'cinema.id = film.cinema_id',
                    'ville'  => 'ville.id = cinema.ville_id',
                    'exploitation' => 'exploitation.film_id = film.id'],
                'order'  => ['exploitation.debut ASC']
            ];

            if($status_id === StatusFilm::EN_SALLE->value) {
                $options['where'][] = 'exploitation.debut <= :debut';

                $date = new \DateTime();
                $date->modify('+2 days');
                $date = $date->format('Y-m-d');
                $options['params']['debut'] = $date
                ;
                $options['where'][] = 'exploitation.fin >= :fin';
                $options['params']['fin'] = date('Y-m-d');
            }

            $movies = $this->dao->findAll($options);

            foreach ($movies as $k => $movie) {
                $movies[$k] = new FilmModel($movie);
            }

            $this->addJavascript(...['path' => 'api/MovieIndex.js', 'module' => true]);
            $this->addJavascript(...['path' => 'js/ajaxRequest.js']);
            return $this->render('Film.index',compact('movies', 'status_id'));
        }

        public function show(string $slug): string
        {

            $options = [
                'select'  => ['*','cinema.nom','ville.id', 'ville.nom','exploitation.debut','exploitation.fin'],
                'contain' => [
                    'cinema' => 'cinema.id = film.cinema_id',
                    'ville'  => 'ville.id = cinema.ville_id',
                    'exploitation' => 'exploitation.film_id = film.id'],
            ];

            $data = $this->dao->findOneBy('slug', $slug, $options);

            $movie = new FilmModel($data);

            if($movie) {

                $_SESSION['film'] = [
                    'id'    => $movie->id,
                    'nom'   => $movie->nom,
                    'cinema' => [
                        'id'    => $movie->cinema->id,
                        'nom'   => $movie->cinema->nom
                    ],
                    'ville' => [
                        'id'    => $movie->cinema->ville->id,
                        'nom'   => $movie->cinema->ville->nom
                    ]
                ];

                $this->page_active = ($movie->status !== StatusFilm::EN_STREAMING)? StatusFilm::EN_SALLE : StatusFilm::EN_STREAMING;

                $this->title_page .= ' | ' . ucfirst($movie->nom);

                $seanceDao = new SeanceDao();
                $options = [
                    'select'  => ['*'],
                    'where'  => ['seance.film_id = :film_id'],
                    'params' => ['film_id' => $movie->id],
                    'order'  => ['seance.date']
                ];

                $seances = $seanceDao->findAll($options);

                foreach ($seances as $k => $seance) {
                    $seances[$k] = new SeanceModel($seance);
                }

                $seances = array_chunk($seances, 3);

            } else {

                MessageFlash::create('Film indisponible',$type = 'warning');
                header('Location: /');
                exit;

            }


            $this->addJavascript(...['path' => 'js/ajaxRequest']);

            return $this->render('Film.show', compact('movie', 'seances'));
        }

        /**
         * @param string $ajax
         *
         * @return void
         */
        public function filmSearch(string $ajax): void
        {
            //supprime le 1er caratère => ?
            $ajax = substr($ajax,1);

            $parts = explode('=', $ajax);

            $col = Security::sanitize($parts[0]);
            $val = Security::sanitize($parts[1]);

            $options = [
                'select' => ['film.*','cinema.nom','ville.nom','exploitation.debut','exploitation.fin'],
                'where'  => ["film.$col LIKE :$col"],
                'params' => [$col => '%'.urldecode($val).'%'],
                'contain' => [
                    'cinema' => 'cinema.id = film.cinema_id',
                    'ville'  => 'ville.id = cinema.ville_id',
                    'exploitation' => 'exploitation.film_id = film.id']
            ];

            $movies = $this->dao->findAll($options,'Json');


            // Afficher le JSON
            echo $movies;
        }

        /**
         * @param string $ajax
         *
         * @return void
         */
        public function filmExist(string $ajax): void
        {
            //supprime le 1er caratère => ?
            $ajax = substr($ajax,1);

            $parts = explode('=', $ajax);

            $col = Security::sanitize($parts[0]);
            $val = Security::sanitize($parts[1]);

            $options = [
                'select' => ['film.*','cinema.nom','ville.nom','exploitation.debut','exploitation.fin'],
                'contain' => [
                    'cinema' => 'cinema.id = film.cinema_id',
                    'ville'  => 'ville.id = cinema.ville_id',
                    'exploitation' => 'exploitation.film_id = film.id']
            ];

            $movie = $this->dao->findOneBy($col, $val, $options);

            echo json_encode($movie, JSON_PRETTY_PRINT);
        }

        /**
         * @return void
         */
        public function statusList(): void
        {
            echo json_encode(StatusFilm::statusToArray());
        }

    }
