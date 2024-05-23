<?php

    namespace Cineflix\App\Controller\Admin;

    use Cineflix\App\AppController;
    use Cineflix\App\DAO\List\Role;
    use Cineflix\App\DAO\List\StatusFilm;
    use Cineflix\App\DAO\FilmDao;
    use Cineflix\App\Model\FilmModel;
    use Cineflix\Core\AbstractController;
    use Cineflix\Core\Router\Router;
    use Cineflix\Core\Util\AuthConnect;
    use Normalizer;

    class Film extends \Cineflix\App\Controller\Film
    {

        protected string $layout = 'admin';

        public function __construct()
        {
            parent::__construct();

            if(!AuthConnect::isConnected() || AuthConnect::getSession()['role'] < Role::ADMINISTRATEUR->value) {
                header('Location: /Signin');
                exit();
            }

        }



        /**
         * @param string|null $status
         *
         * @return string
         */
        public function index(?string $status = null): string
        {
            $status = (!is_null($status)) ? StatusFilm::getStatusByName($status) : null;
            $buttons = [];

            if($status !== StatusFilm::EN_SALLE || !is_null($status)){
                $id = StatusFilm::EN_SALLE->value;
                $buttons[$id] = self::$_Router->getUrl('admin_film_add', [ 'status' => StatusFilm::getUrlById($id) ]);
            }
            if($status !== StatusFilm::EN_STREAMING || !is_null($status)) {
                $id = StatusFilm::EN_STREAMING->value;
                $buttons[$id] = self::$_Router->getUrl('admin_film_add',[ 'status' => StatusFilm::getUrlById($id)]);
            }

            $options = [
                'select'  => ['film.*','cinema.nom','ville.nom','exploitation.debut','exploitation.fin'],
                'contain' => [
                    'cinema' => 'cinema.id = film.cinema_id',
                    'ville'  => 'ville.id = cinema.ville_id',
                    'exploitation' => 'exploitation.film_id = film.id'],
                'order'  => 'film.modified'
            ];

            if(!is_null($status)) {
                $options['where']  = ['film.status = :status'];
                $options['params'] = ['status' => StatusFilm::getStatusId($status->name)];
            }

            $movies = $this->dao->findAll($options);

            return $this->render('Film.admin.index',compact('movies', 'buttons', 'status'));
        }



        /**
         * @param string|null $status
         * @param int|null    $id
         *
         * @return string
         */
        public function edit(string $status = null, int $id = null): string
        {
            $movie = new FilmModel();
            $movie->setStatus($status);


            $title = "Ajouter un film ".StatusFilm::toString($movie->status_id);
            $form_id = "AddMovie";

            if (!is_null($id)) {
                $title =  "Editer: ".ucwords($movie->nom);
                $form_id = "EditMovie";
            }

            $url = self::$_Router->getUrl('admin_film_add',['status' => $status]);
            $class = ($movie->status == StatusFilm::EN_SALLE->value)? 'en-salle' : 'streaming';


            // ajouter si c'est un ajout dans une salle une verification si il n'est pas deja en salle
            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                $movie->hydrate($_POST);

                //$movie->addValidation('nom',['alphaNumeric', 'require']);
                //$movie->addValidation('date_sortie',['date', 'require']);
                //$movie->addValidation('synopsis',['require']);
                //$movie->addValidation('cinema_id',['numeric', 'require']);
                //$movie->exploitation->addValidation('debut',['alphaNumeric', 'require']);
                //$movie->exploitation->addValidation('fin',['alphaNumeric', 'require']);
                //$movie->addValidation('affiche',['file', 'require']);
                //$movie->isValid() &&
                if($this->dao->create($movie)) {

                }
                //var_dump($movie);
                //var_dump($movie->getErrors());die();
            }


            $props = [
                'form_id'   => $form_id,
                'title'     => $title,
                'class'     => $class,
                'url'       => $url,
                'movie'     => $movie,
                'errors'    => $movie->getErrors()
            ];

            $this->addJavascript(...['path' => 'js/jquery-ui.js', 'head' => true]);
            $this->addJavascript(...['path' => 'js/app.js', 'module' => true]);
            return $this->render('Film.admin.edit', $props);
        }



        /**
         * @return void
         */
        public function delete()
        {

        }


    }