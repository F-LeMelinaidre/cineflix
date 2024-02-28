<?php

namespace Cineflix\App;


use Cineflix\Core\Database\Database;
use Cineflix\Core\Router\RouteNotFoundException;
use Cineflix\Core\Router\Router;

require '../vendor/autoload.php';

// TODO
//  - Creer une methode ou class pour gérer l'affichage d'erreur, et la redirection vers les pages d'erreurs

class AppController
{
    const APP_NAME = 'Cinéflix';

    public static string $_Root;
    public static string $_Webroot;
    public static Router $_Router;
    public static Database $_Database;

    private string $controller_path = '\\Cineflix\\App\\Controller\\';

    public function __construct() {
        self::$_Root = dirname(__DIR__);
        self::$_Webroot = self::$_Root.'/public/';

        self::$_Router = Router::getInstance();
        self::$_Database = Database::getInstance(self::$_Root);
    }

    public function run()
    {
        // Création de l'ensemble des routes de l'application



        self::$_Router->get(
            '/',
            ['controller' => 'home', 'action' => 'index'],
            'home.index'
        );

        self::$_Router->get(
            '/Signin',
            [
                'controller' => 'Auth', 'action' => 'signin'
            ],
            'signin'
        );

        self::$_Router->get(
            '/Auth/signup',
            [
                'controller' => 'Auth', 'action' => 'signup'
            ],
            'Account.create'
        );

        self::$_Router->get(
            '/Movies',
            [
                'controller' => 'movie', 'action' => 'index'
            ],
            'movies.index'
        );
        self::$_Router->get(
            '/Movie/:slug-:id',
            [
                'controller' => 'movie', 'action' => 'show', 'require' => ['slug' => '[a-z\_\-0-9]+', 'id' => '[0-9]+']
            ],
            'movie.show'
        );

        self::$_Router->get('/Profil',
            [
                'controller' => 'profil', 'action' => 'index'
            ],
            'profil.index'
        );

        self::$_Router->get('/Streams',
            [
                'controller' => 'streaming', 'action' => 'index'
            ],
            'streaming.index'
        );
        self::$_Router->get(
            '/Stream/:slug-:id',
            [
                'controller' => 'streaming', 'action' => 'index', 'require' => ['slug' => '[a-z\-0-9]+', 'id' => '[0-9]+']
            ],
            'streaming.show'
        );

        self::$_Router->get(
            '/User',
            [
                'controller' => 'user', 'action' => 'index'
            ],
            'user.index'
        );

        try {
            $route = self::$_Router->routeMatched();

            $controller = $this->controller_path.ucfirst($route['controller']);
            $action = $route['action'];

            $controller = new $controller();

            return $controller->$action();

        } catch (RouteNotFoundException $exception) {
            // TODO Créer les pages d'erreur
            return "Erreur : " . $exception->getMessage();
        }

    }
}
