<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\DAO\List\Role;
    use Cineflix\App\DAO\List\StatusFilm;
    use Cineflix\App\DAO\FilmDao;
    use Cineflix\App\DAO\SeanceDao;
    use Cineflix\Core\AbstractController;
    use Cineflix\Core\Util\GenerateIdentifiant;
    use Cineflix\Core\Util\Security;

    class Film extends AbstractController
    {
        protected FilmDao $filmDao;

        public function index(?string $status = null): string
        {

            $status_id = (!is_null($status)) ? StatusFilm::getStatusId($status) : StatusFilm::EN_SALLE->value;

            $this->page_active = StatusFilm::getUrlById($status_id);

            $options = [
                'select'  => ['film.*','cinema.nom','ville.nom','exploitation.debut','exploitation.fin'],
                'where'  => ['film.status = :status'],
                'params' => ['status' => $status_id],
                'contain' => [
                    'cinema' => 'cinema.id = film.cinema_id',
                    'ville'  => 'ville.id = cinema.ville_id',
                    'exploitation' => 'exploitation.film_id = film.id'],
                'order'  => 'film.modified'
            ];

            if($status_id === StatusFilm::EN_SALLE->value) {
                $options['where'][] = 'exploitation.fin >= :current_date';
                $options['params']['current_date'] = date('Y-m-d');
            }

            $movies = $this->dao->findAll($options);

            $this->addJavascript(...['path' => 'api/MovieIndex.js', 'module' => true]);
            $this->addJavascript(...['path' => 'js/ajaxRequest.js']);
            return $this->render('Film.index',compact('movies', 'status_id'));
        }

        public function show(string $slug): string
        {

            $options = [
                'select'  => ['*','cinema.nom','ville.nom'],
                'contain' => [
                    'cinema' => 'cinema.id = film.cinema_id',
                    'ville'  => 'ville.id = cinema.ville_id'],
            ];

            $movie = $this->dao->findOneBy('slug', $slug, $options);
            $this->page_active = StatusFilm::getUrlById($movie->status_id);
            $this->title_page .= ' | ' . ucfirst($movie->nom);

            $seanceDao = new SeanceDao();
            $options = [
                'select'  => ['*'],
                'where'  => ['seance.film_id = :film_id'],
                'params' => ['film_id' => $movie->id],
                'order'  => 'seance.date'
            ];

            $seances = $seanceDao->findAll($options);


            $seances = array_chunk($seances, 3);

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

            $movie = $this->dao->findOneBy($col, $val, $options, 'Json');

            echo $movie;
        }

        /**
         * @return void
         */
        public function statusList(): void
        {
            echo json_encode(StatusFilm::statusToArray());
        }

    }
