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
        self::$_Router->get('home', '/', [Controller\Home::class, 'index']);
        self::$_Router->get('signin', '/Signin', [Controller\Auth::class, 'signin']);
        self::$_Router->get('signup', '/Signup', [Controller\Auth::class, 'signup']);

        self::$_Router->get('movie_index', '/Movie', [ Controller\Movie::class, 'index']);
        self::$_Router->get('movie_show', '/Movie/{slug}-{id}', [ Controller\Movie::class, 'show'],
            ['slug' => '[a-zA-Z_]+', 'id' => '[0-9]+']);

        self::$_Router->get('streaming_index', '/Streaming', [Controller\Streaming::class, 'index']);
        self::$_Router->get('streaming_show', '/Streaming/{slug}-{id}', [Controller\Streaming::class, 'show'],
            ['slug' => '[a-zA-Z_]+', 'id' => '[0-9]+']);

        self::$_Router->get('admin_movie_index', '/Admin/Movie', [ Controller\Movie::class, 'index']);
        self::$_Router->get('admin_movie_show', '/Admin/Movie/{slug}-{id}', [ Controller\Movie::class, 'show'],
            ['slug' => '[a-zA-Z_]+', 'id' => '[0-9]+']);


        try {
            $route = self::$_Router->resolve();
            $callback = $route->callback;
            $params = $route->matches;

            if (is_array($callback)) {
                $controller = new $callback[0]();
                $controller->action = $callback[1];
                $callback[0] = $controller;
            }

            return call_user_func_array($callback, $params);


        } catch (RouteNotFoundException $exception) {
            // TODO Créer les pages d'erreur
            return "Erreur : " . $exception->getMessage();
        }

    }
}
