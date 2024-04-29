<?php

    namespace Cineflix\App\Controller\Admin;

    use Cineflix\App\AppController;
    use Cineflix\App\DAO\List\Role;
    use Cineflix\App\DAO\List\StatusMovie;
    use Cineflix\App\DAO\MovieDao;
    use Cineflix\App\Model\MovieModel;
    use Cineflix\Core\AbstractController;
    use Cineflix\Core\Router\Router;
    use Cineflix\Core\Util\AuthConnect;

    class Movie extends AbstractController
    {
        private MovieDao $movieDao;

        protected string $layout = 'admin';

        public function __construct()
        {
            parent::__construct();

            if(!AuthConnect::isConnected() || AuthConnect::getSession()['role'] < Role::ADMINISTRATEUR->value) {
                header('Location: /');
                exit();
            }
            $this->movieDao = new $this->dao();
        }

        public function index(?string $status = null): string
        {
            $status_id = (!is_null($status)) ? StatusMovie::getStatus($status) : null;
            $buttons = [];

            if($status_id !== StatusMovie::EN_SALLE->value || !is_null($status_id)){
                $id = StatusMovie::EN_SALLE->value;
                $buttons[StatusMovie::EN_SALLE->value] = self::$_Router->getUrl('admin_movie_add', [ 'status' => StatusMovie::getUrl($id) ]);
            }
            if($status_id !== StatusMovie::EN_STREAMING->value || !is_null($status_id)) {
                $id = StatusMovie::EN_STREAMING->value;
                $buttons[StatusMovie::EN_STREAMING->value] = self::$_Router->getUrl('admin_movie_add',['status' => StatusMovie::getUrl($id)]);
            }

            $options = [
                'select'  => ['movie.*','cinema.nom','ville.nom'],
                'contain' => [
                    'cinema' => 'cinema.id = movie.cinema_id',
                    'ville'  => 'ville.id = cinema.ville_id'],
                'order'  => ['movie.modified']
            ];

            if(!is_null($status)) {
                $options['where']  = ['status = :status'];
                $options['params'] = ['status' => $status];
            }

            $movies = $this->movieDao->findAll($options);

            return $this->render('Movie.admin.index',compact('movies', 'buttons', 'status_id'));
        }

        public function show(int $id){}

        public function edit(string $status = null, int $id = null): string
        {
            $movie = new MovieModel();
            $movie->status = !is_null($status) ? StatusMovie::getStatus($status) : null;

            // ajouter si c'est un ajout dans une salle une verification si il n'est pas deja en salle
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $movie->setNom($_POST['nom']);
                $movie->setDateSortie($_POST['date_sortie']);
                $movie->setSynopsis($_POST['synopsis']);
                if(StatusMovie::EN_SALLE === $movie->status) {
                    $movie->setCinemaId($_POST['cinema_id']);
                    $movie->exploitation->setExploitationDebut($_POST['exploitation_debut']);
                    $movie->exploitation->setExploitationFin($_POST['exploitation_fin']);
                }
                $movie->setAffiche($_POST['affiche']);

                //$movie->setCinemaId(intval($_POST['cinema_id']));

                //$movie->addValidation('nom',['alphaNumeric', 'require']);
                //$movie->addValidation('date_sortie',['date', 'require']);
                //$movie->addValidation('synopsis',['require']);
                //$movie->addValidation('cinema_id',['numeric', 'require']);
                //$movie->addValidation('exploitation_debut',['alphaNumeric', 'require']);
                //$movie->addValidation('exploitation_fin',['alphaNumeric', 'require']);
                //$movie->addValidation('affiche',['file', 'require']);

                if($this->movieDao->create($movie)) {
                    echo 'ok';
                }

            }

            $errors = $movie->getErrors();

            $title = (!isset($id))? "Ajouter un film ".StatusMovie::toString($movie->status) : "Editer: ".ucwords($movie->nom);

            $url = self::$_Router->getUrl('admin_movie_add',['status' => $status]);

            return $this->render('Movie.admin.edit',compact('title', 'movie', 'url'));
        }

        public function delete()
        {

        }


    }