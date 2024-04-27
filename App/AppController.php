<?php

    namespace Cineflix\App;


    use Cineflix\App\Model\UserModel;
    use Cineflix\Core\Database\Database;
    use Cineflix\Core\Router\RouteNotFoundException;
    use Cineflix\Core\Router\Router;
    use Cineflix\Core\Util\AuthConnect;

    // Charge la class autoload (package de composer)
    require '../vendor/autoload.php';

    // TODO
    //  - Creer une methode ou class pour gérer l'affichage d'erreur, et la redirection vers les pages d'erreurs

    class AppController
    {
        // Utilisé entre autre pour le tag HTML title
        const APP_NAME = 'Cinéflix';

        /**
         * @var string Racine de l'app
         */
        public static string $_Root;
        /**
         * @var string Chemin du dossier public de l'app
         */
        public static string $_Webroot;

        /**
         * @var Router instance de class Core/Router/Router.php
         */
        public static Router $_Router;

        /**
         * @var Database instance de class Core/Database/Database.php
         *               connection via PDO
         */
        public static Database $_Database;

        public function __construct() {
            self::$_Root = dirname(__DIR__);
            self::$_Webroot = self::$_Root.'/public/';

            self::$_Router = Router::getInstance();
            self::$_Database = Database::getInstance(self::$_Root);

            AuthConnect::init(self::$_Database, 'user', 'email', self::APP_NAME);
        }

        public function run()
        {
            // 1er parametre nom de la route
            // 2nd le format de l'url qui doit estre matché
            // 3eme tableau de paramètre contenant la class controller et le nom de la méthode
            // 4eme optionnel tableau [nom du paramètre => format de la valeur (expression régulière)]
            self::$_Router->get('home', '/', [Controller\Home::class, 'index']);

            self::$_Router->get('signin', '/Signin', [Controller\Auth::class, 'signin']);
            self::$_Router->get('signup', '/Signup', [Controller\Auth::class, 'signup']);
            self::$_Router->get('finalize_signup', '/Signup/Finalise', [Controller\Auth::class, 'finalizeSignup']);

            self::$_Router->post('signin', '/Signin', [Controller\Auth::class, 'signin']);
            self::$_Router->post('signup', '/Signup', [Controller\Auth::class, 'signup']);
            self::$_Router->post('finalize_signup', '/Signup/Finalise', [Controller\Auth::class, 'finalizeSignup']);

            self::$_Router->get('signout', '/Signout', [Controller\Auth::class, 'signout']);

            self::$_Router->get('movie_index', '/Movie', [ Controller\Movie::class, 'index']);
            self::$_Router->get('movie_show', '/Movie/{slug}', [ Controller\Movie::class, 'show'],
                ['slug' => '[A-Z_]+']);

            self::$_Router->get('streaming_index', '/Streaming', [Controller\Streaming::class, 'index']);
            self::$_Router->get('streaming_show', '/Streaming/{slug}', [Controller\Streaming::class, 'show'],
                ['slug' => '[A-Z_]+']);

            self::$_Router->get('profil_show', '/Profil', [ Controller\Profil::class, 'show']);
            self::$_Router->get('profil_edit_identite', '/Profil/Edit/Identite', [ Controller\Profil::class, 'editIdentite']);
            self::$_Router->get('profil_edit_adresse', '/Profil/Edit/Adresse', [ Controller\Profil::class, 'editAdresse']);
            self::$_Router->get('profil_edit_authentification', '/Profil/Edit/Authentification', [ Controller\Profil::class, 'editAuthentification']);

            self::$_Router->post('profil_edit_adresse', '/Profil/Edit/Adresse', [ Controller\Profil::class, 'editAdresse']);
            self::$_Router->post('profil_edit_identite', '/Profil/Edit/Identite', [ Controller\Profil::class, 'editIdentite']);
            self::$_Router->post('profil_edit_authentification', '/Profil/Edit/Authentification', [ Controller\Profil::class, 'editAuthentification']);

            //Route partie Admin
            //Admin Home
            self::$_Router->get('admin_home_index', '/Admin/Home', [ Controller\Admin\Home::class, 'index']);

            //Admin Cinema
            self::$_Router->get('admin_cinema_index', '/Admin/Cinema', [ Controller\Admin\Cinema::class, 'index']);
            self::$_Router->get('admin_cinema_add', '/Admin/Cinema/Add', [ Controller\Admin\Cinema::class, 'edit']);
            self::$_Router->get('admin_cinema_edit', '/Admin/Cinema/Edit/{id}', [ Controller\Admin\Cinema::class, 'edit'],
                ['id' => '[0-9]+']);

            //Admin Film
            self::$_Router->get('admin_movie_index', '/Admin/Film', [ Controller\Admin\Movie::class, 'index']);
            self::$_Router->get('admin_movie_add', '/Admin/Movie/Add', [ Controller\Admin\Movie::class, 'edit']);
            self::$_Router->get('admin_movie', '/Admin/Film/{status}', [ Controller\Admin\Movie::class, 'index'],
                ['status' => '[A-Z-]+']);

            self::$_Router->get('admin_movie_edit', '/Admin/Movie/Edit/{id}', [ Controller\Admin\Movie::class, 'edit'],
                ['id' => '[0-9]+']);

            self::$_Router->post('admin_movie_add', '/Admin/Movie/Add', [ Controller\Admin\Movie::class, 'edit']);
            self::$_Router->post('admin_movie_edit', '/Admin/Movie/Edit/{id}', [ Controller\Admin\Movie::class, 'edit'],
                ['id' => '[0-9]+']);

            //Admin Streaming
            self::$_Router->get('admin_streaming_index', '/Admin/Streaming', [ Controller\Admin\Streaming::class, 'index']);
            self::$_Router->get('admin_streaming_add', '/Admin/Streaming/Add', [ Controller\Admin\Streaming::class, 'edit']);
            self::$_Router->get('admin_streaming_edit', '/Admin/Streaming/Edit/{id}', [ Controller\Admin\Streaming::class, 'edit'],
                ['id' => '[0-9]+']);

            //Admin User
            self::$_Router->get('admin_user_index', '/Admin/User', [ Controller\Admin\User::class, 'index']);
            self::$_Router->get('admin_user_show', '/Admin/User/{id}', [ Controller\Admin\User::class, 'show'],
                ['id' => '[0-9]+']);
            self::$_Router->get('admin_user_edit', '/Admin/User/Edit/{id}', [ Controller\Admin\User::class, 'edit'],
                ['id' => '[0-9]+']);

            //Requete Ajax
            self::$_Router->post('ajax_cinemaSearch', '/Ajax/cinemaSearch', [ Ajax\AjaxRequest::class, 'cinemaSearch']);
            self::$_Router->post('ajax_filmSearch', '/Ajax/filmSearch', [ Ajax\AjaxRequest::class, 'filmSearch']);


            try {
                // Controlle l'url et dirige vers le bon controller et methode si l'url match avec une route précédement créé
                // Sinon lève une exception
                $route = self::$_Router->resolve();
                $callback = $route->callback;
                $params = $route->matches;


                $controller = new $callback[0]();
                $callback[0] = $controller;


                // call_user_func_array Retourne une methode de Class instancié
                // Le parametre $callback doit etre une methode d'objet instancié sous forme de tableau
                // index 0: la Class
                // index 1: la methode
                // $params est un tableau des paramètres passés à la méthode de la Class $callback
                // return vers public/index.view

                return call_user_func_array($callback, $params);


                // call_user_func_array Retourne une methode de Class instancié
                // Le parametre $callback doit etre une methode d'objet instancié sous forme de tableau
                // index 0: la Class
                // index 1: la methode
                // $params est un tableau des paramètres passés à la méthode de la Class $callback
                // return vers public/index.view
                return call_user_func_array($callback, $params);

            } catch (RouteNotFoundException $exception) {
                // TODO Créer les pages d'erreur
                return "Erreur : " . $exception->getMessage();
            }

        }
    }
