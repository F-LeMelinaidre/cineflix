<?php

    namespace Cineflix\App\Controller\Admin;

    use Cineflix\App\DAO\List\StatusMovie;
    use Cineflix\App\DAO\MovieDao;
    use Cineflix\App\Model\MovieModel;
    use Cineflix\Core\AbstractController;

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

            if(is_null($status)) {
                $movies = $this->movieDao->findAll(['order' => ['created']]);
            } else {
                $movies = $this->movieDao->findAllByStatus($status);
            }

            return $this->render('Movie.admin.index',compact('movies'));
        }

        public function cinema(): string
        {
            $movies = $this->movieDao->findAllByStatus(StatusMovie::EN_SALLE);

            return $this->render('Movie.admin.index',compact("movies"));
        }

        public function show(int $id){}

        public function edit(int $id = null): string
        {
            $movieDao = new MovieDao();
            // ajouter si c'est un ajout dans une salle une verification si il n'est pas deja en salle
            if(!empty($_POST)) {

                $movie = new MovieModel();

                $movie->nom = $_POST['nom'];
                $movie->synopsis = $_POST['synopsis'];
                $movie->cinema = $_POST['cinema'];
                $movie->date_sortie = strtotime($_POST['date_sortie']);
                $movie->affiche = $_POST['affiche'];

                $movieDao->add($movie);

                $url = '';
            } else {
                // si id n est pas null update
                if (!is_null($id)) {

                    $movie = $movieDao->findBy('id', $id);
                    $timeToDate = strtotime($movie->date_sortie);
                    //$movie->cinema->nom = $movie->cinema->nom. ' - ' .$movie->ville->nom;
                    $url = self::$_Router->getUrl('admin_movie_edit', [ 'id' => $id ]);

                    // sinon ajout
                } else {
                    $movie = new MovieModel();

                    $url = self::$_Router->getUrl('admin_movie_add');
                }
            }

            $title = (!isset($movie->id))? "Ajouter un film" : "Editer: ".ucwords($movie->nom);

            return $this->render('Movie.admin.edit',compact('title', 'movie', 'url'));
        }

        public function delete()
        {

        }


    }