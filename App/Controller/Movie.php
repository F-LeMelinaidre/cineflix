<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\DAO\List\StatusMovie;
    use Cineflix\App\DAO\MovieDao;
    use Cineflix\App\DAO\SeanceDao;
    use Cineflix\Core\AbstractController;

    class Movie extends AbstractController
    {
        protected MovieDao $movieDao;
        public function __construct()
        {
            parent::__construct();

            $this->movieDao = new $this->dao();
        }

        public function index(?string $status = null): string
        {
            $status_id = StatusMovie::getStatus($status);

            $options = [
                'select'  => ['movie.*','cinema.nom','ville.nom AS cinema_ville_nom'],
                'where'  => ['status = :status'],
                'params' => ['status' => $status_id],
                'contain' => [
                    'cinema' => 'cinema.id = movie.cinema_id',
                    'ville'  => 'ville.id = cinema.ville_id'],
                'order'  => ['movie.modified']
            ];

            $movies = $this->movieDao->findAll($options);

            return $this->render('Movie.index',compact('movies', 'status_id'));
        }

        public function show(string $slug): string
        {
            /* TODO Créer un find movieWithSeance */
            /*  Faire un JOIN seance */
            /*  ne pas lui passer la class pour le setFetchMode */
            /*  à la place un fois l'enregistrement récuperer dans cette méthode */
            /*  avant de retourner le resultat instancier la class movieModel */
            /*  lui passer les colonnes en parametres ou faire et utiliser des setters */
            /*  ** pour par exemple formater la date de sortie du film */
            /*  ** et également, comme séance est lié à movie creer dans le model movie */
            /*  une propriété scéances qui serai un tableau et un setter setSeances contenant une boucle */
            /*  la boucle contient soit: */
            /*      une intanciation la class sceance (le model n'existe pas!!) */
            /*      elle pourrai entre autre de reformater la date et plus tard effectuer d'autre chose */
            /*       Ou au lieu d'avoir un model seance reformater la date */
            $movieDao = new MovieDao();
            $movie = $movieDao->findBy('slug', $slug);
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

            $movies = $this->movieDao->findAll($options);
            // Convertir le tableau PHP en format JSON
            $jsonData = json_encode($movies, JSON_PRETTY_PRINT);

            // Afficher le JSON
            echo $jsonData;
        }

    }
