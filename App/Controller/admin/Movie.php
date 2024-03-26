<?php

namespace Cineflix\App\Controller\Admin;

use Cineflix\App\Model\DAO\FicheDao;
use Cineflix\App\Model\DAO\MovieDao;
use Cineflix\App\Model\MovieModel;
use Cineflix\Core\AbstractController;

class Movie extends AbstractController
{

    protected string $layout = 'admin';

    public function index(): string
    {
        $movieDao = new MovieDao();
        $movies = $movieDao->findAll();
        return $this->render('Movie.admin.index',compact("movies"));
    }

    public function show(int $id){}

    public function edit(int $id = null): string
    {
        $test = new FicheDao();
        $fiche = $test->ajaxEstEnSalle('nom', 'les affranchis');

        $movieDao = new MovieDao();
        // ajouter si c'est un ajout dans une salle une verification si il n'est pas deja en salle
        if(!empty($_POST)) {

            $movie = new MovieModel();

            $movie->nom = $_POST['nom'];
            $movie->cinopsys = $_POST['cinopsys'];
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
                $movie->date_sortie = date("Y-m-d", $timeToDate);
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

    public function selectTown(int $id) {
        $db = AppController::$_Database;
        $query = "SELECT * FROM ville WHERE id = :id";
        $binvalue[] = ['col' => 'id', 'val' => $id];
        $req = $db->prepare($query, $binvalue);
        $ville = $req->fetch(VilleModel::class);
        return $ville->nom;
    }

}