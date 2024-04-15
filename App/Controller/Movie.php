<?php

    namespace Cineflix\App\Controller;

    use Cineflix\App\Model\DAO\MovieDao;
    use Cineflix\App\Model\DAO\SeanceDao;
    use Cineflix\Core\AbstractController;

    class Movie extends AbstractController
    {

        public function index(): string
        {
            $movieDao = new MovieDao();
            $movies = $movieDao->findAll();
            return $this->render('Movie.index', compact('movies'));

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
            var_dump($movie);
            die();
            $seanceDao = new SeanceDao();
            $seances = $seanceDao->findAllFromMovie($movie->movie_id);

            return $this->render('Movie.show', compact('movie', 'seances'));
        }

    }
