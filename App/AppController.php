<?php

namespace Cineflix\App;


use Cineflix\Core\Router\Router;

require '../vendor/autoload.php';

// TODO
//      - Revoir l'import de header.php dans index.php
//          Pour la gestion des liens
//          Et si le header doit être importé ou non suivant les pages (exemple: connexion, et création de compte)
//      - Remonter l'instanciation des controller effectué dans la Class Route Methode call() ici
//      - Creer une methode ou class pour gérer l'affichage d'erreur, et la redirection vers les pages d'erreurs
//      - Déplacer et Renommer Les Constantes ROOT et WEBROOT ici
//      - Essayer de ne laisser dans l'index seulement:
//          ini_set()
//          session_start()
//          date_default_timezone_set()
//          ainsi que l'appel à APP::load() biensûr sinon rien ne fonctionne

class AppController
{
    const APP_NAME = 'Cinéflix';
    const CONTROLLER_PATH = '\\Cineflix\\App\\Controller\\';

    private static $instance;
    public static function getInstance() {
        if(!self::$instance) self::$instance = new AppController();

        return self::$instance;
    }
    public function load():void
    {
        // Création de l'ensemble des routes de l'application
        $router = Router::getInstance();
        $router = $this->createRoute($router);

        $route = $router->match();

        $this->loadPage($route);

    }

    // TODO
    //  Gerer les pages erreurs if(!empty($route)) ...
    //  Creer les routes et les pages erreurs
    private function loadPage(array $route) {

        $controller = self::CONTROLLER_PATH.$route['controller'].'Controller';

        $action = $route['action'];

        $controller = new $controller();
        $controller->$action();
    }

    private function createRoute(Router $router):Router
    {


        $router->get('/',
            [
                'controller' => 'home',
                'action' => 'index'
            ],
            'home.index'
        );

        $router->get('/Signin',
            [
                'controller' => 'Auth',
                'action' => 'signin'
            ],
            'signin'
        );

        $router->get('/Auth/signout',
            [
                'controller' => 'Auth',
                'action' => 'signout'
            ],
            'auth.signout'
        );

        $router->get('/Movies',
            [
                'controller' => 'movie',
                'action' => 'index'
            ],
            'movies.index'
        );

        $router->get('/Movie/:slug-:id',
            [
                'controller' => 'movie',
                'action' => 'show',
                'require' => [
                    'slug' => '[a-z\-0-9]+',
                    'id' => '[0-9]+'
                ]
            ],
            'movie.show'
        );

        $router->get('/Profil',
            [
                'controller' => 'profil',
                'action' => 'index'
            ],
            'profil.index'
        );

        $router->get('/Streams',
            [
                'controller' => 'streaming',
                'action' => 'index'
            ],
            'streaming.index'
        );

        $router->get('/Stream/:slug-:id',
            [
                'controller' => 'streaming',
                'action' => 'index',
                'require' => [
                    'slug' => '[a-z\-0-9]+',
                    'id' => '[0-9]+'
                ]
            ],
            'streaming.show'
        );

        $router->get('/User',
            [
                'controller' => 'user',
                'action' => 'index'
            ],
            'user.index'
        );

        return $router;
    }


}
