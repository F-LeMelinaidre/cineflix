<?php

    namespace Cineflix\App\Controller\Admin;

    use Cineflix\App\AppController;
    use Cineflix\App\DAO\List\StatusMovie;
    use Cineflix\App\DAO\MovieDao;
    use Cineflix\App\Model\MovieModel;
    use Cineflix\Core\AbstractController;
    use Cineflix\Core\Router\Router;

    class Movie extends AbstractController
    {
        private MovieDao $movieDao;

        protected string $layout = 'admin';

        public function __construct()
        {
            parent::__construct();

            $this->movieDao = new $this->dao();
        }

        public function index(?string $status = null): string
        {
            $status_id = (!is_null($status)) ? StatusMovie::getStatus($status) : null;
            $buttons = [
                StatusMovie::getStatus('en salle') => self::$_Router->getUrl('admin_movie_add',['status' => StatusMovie::getUrl('en salle')]),
                StatusMovie::getStatus('en streaming') => self::$_Router->getUrl('admin_movie_add',['status' => StatusMovie::getUrl('en streaming')])
            ];

            $options = [
                'select'    => ['movie.*','cinema.nom','ville.nom'],
                'contain'   => ['cinema','ville'],
                'order'     => ['movie.modified']
            ];

            if(is_null($status)) {
                $movies = $this->movieDao->findAll($options);
            } else {
                $movies = $this->movieDao->findAllByStatus($status);
            }

            return $this->render('Movie.admin.index',compact('movies', 'buttons', 'status_id'));
        }

        public function cinema(): string
        {
            $movies = $this->movieDao->findAllByStatus(StatusMovie::EN_SALLE);

            return $this->render('Movie.admin.index',compact("movies"));
        }

        public function show(int $id){}

        public function edit(string $status = null, int $id = null): string
        {
            $errors = [];
            // ajouter si c'est un ajout dans une salle une verification si il n'est pas deja en salle
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $status_id = StatusMovie::getStatus($status);
                $movie = new MovieModel();
                $movie->setNom($_POST['nom']);
                $movie->setDateSortie($_POST['date_sortie']);
                $movie->setSynopsis($_POST['synopsis']);

                //$movie->setCinemaId(intval($_POST['cinema_id']));

                //$movie->addValidation('nom',['rule' => 'alphaNumeric', 'require' => true]);
                //$movie->addValidation('date_sortie',['rule' => 'alphaNumeric', 'require' => true]);
                //$movie->addValidation('synopsis',['require' => true]);
                //$movie->addValidation('cinema_id',['rule' => 'numeric', 'require' => true]);

                if($this->movieDao->create($movie)) {
                    echo 'ok';
                }

                $errors = $movie->getErrors();
            } else {

            }

            var_dump($errors);

            $title = (!isset($id))? "Ajouter un film" : "Editer: ".ucwords($movie->nom);

            $url = self::$_Router->getUrl('admin_movie_add',['status' => $status]);
            $movie = [];

            return $this->render('Movie.admin.edit',compact('title', 'movie', 'url'));
        }

        public function delete()
        {

        }


    }