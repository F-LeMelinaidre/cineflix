<?php

    namespace Cineflix\App\Controller\Admin;

    use Cineflix\App\AppController;
    use Cineflix\App\DAO\CinemaDao;
    use Cineflix\App\DAO\List\Role;
    use Cineflix\App\DAO\List\StatusFilm;
    use Cineflix\App\DAO\FilmDao;
    use Cineflix\App\DAO\VilleDao;
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
            $request_options = [
                'select'  => ['film.*','cinema.id', 'cinema.nom', 'ville.id', 'ville.nom', 'exploitation.debut', 'exploitation.fin'],
                'contain' => [
                    'cinema' => 'film.cinema_id = cinema.id',
                    'ville' => 'cinema.ville_id = ville.id',
                    'exploitation' => 'exploitation.film_id = film.id'
                ],
                'order'  => ['exploitation.fin', 'ASC']
            ];

            $status = (!is_null($status)) ? StatusFilm::getStatusByName($status) : null;
            $buttons = [];

            if(!is_null($status)) {

                $id = $status->value;
                if ($status === StatusFilm::EN_SALLE || $status === StatusFilm::EN_STREAMING)
                    $buttons[StatusFilm::toString($status)] = self::$_Router->getUrl('admin_film_add', [ 'status' => StatusFilm::getUrlById($id) ]);

                $request_options['where']  = ['film.status = :status'];
                $request_options['params'] = ['status' => $id];

            } else {

                $buttons = [

                    StatusFilm::toString(StatusFilm::EN_SALLE) => self::$_Router->getUrl('admin_film_add', [
                        'status' => StatusFilm::getUrlById(StatusFilm::EN_SALLE->value) ]),

                    StatusFilm::toString(StatusFilm::EN_STREAMING) => self::$_Router->getUrl('admin_film_add', [
                        'status' => StatusFilm::getUrlById(StatusFilm::EN_STREAMING->value) ]),
                ];
            }

            $movies = $this->dao->findAll($request_options);

            foreach ($movies as $k => $movie) {
                $movies[$k] = new FilmModel($movie);
            }

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

            $title = "Ajouter un film ".StatusFilm::toString($movie->status);
            $form_id = "AddMovie";

            if (!is_null($id)) {
                $title =  "Editer: ".ucwords($movie->nom);
                $form_id = "EditMovie";
            }

            $url = self::$_Router->getUrl('admin_film_add',['status' => $status]);
            $class = ($movie->status == StatusFilm::EN_SALLE)? 'en-salle' : 'streaming';


            // ajouter si c'est un ajout dans une salle une verification si il n'est pas deja en salle
            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                $movie->hydrate($_POST);

                $villeDAO = new VilleDao();

                $params = ['select' => ['*']];
                $ville = $villeDAO->findOneBy('nom', $movie->cinema->ville->nom, $params);

                $cinemaDAO = new CinemaDao();

                $params = [
                    'select' => ['cinema.id','cinema.nom','ville.id', 'ville.nom'],
                    'contain' => ['ville' => 'ville.id = cinema.ville_id'],
                    'where' => ['ville.nom = :ville_nom'],
                    'params' => ['ville_nom' => $movie->cinema->ville->nom]
                ];
                $cinema = $cinemaDAO->findOneBy('nom', $movie->cinema->nom, $params);

                if($cinema) {
                    $movie->cinema->setId($cinema['id']);
                    $movie->cinema->ville->setId($ville['id']);
                }

                if(!$cinema && $ville) $movie->cinema->ville->setId($ville['id']);

                $movie->addValidation('nom',['alphaNumeric', 'require']);
                $movie->addValidation('date_sortie',['date', 'require']);
                $movie->addValidation('synopsis',['require']);
                //$movie->addValidation('affiche',['file', 'require']);

                if($movie->status == StatusFilm::EN_SALLE->value) {

                    $movie->exploitation->addValidation('debut',['alphaNumeric', 'require']);
                    $movie->exploitation->addValidation('fin',['alphaNumeric', 'require']);
                }


                if(!$movie->isValid()) {
                    var_dump($movie->getErrors());die();
                }
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
            $this->addJavascript(...['path' => 'js/component/CinemaVilleInput.js', 'module' => true]);
            $this->addJavascript(...['path' => 'js/component/FormValidation.js', 'module' => true]);
            return $this->render('Film.admin.edit', $props);
        }



        /**
         * @return void
         */
        public function delete()
        {

        }


    }