<?php

namespace Cineflix\App;


use Cineflix\Core\Database\Database;
use Cineflix\Core\Router\RouteNotFoundException;
use Cineflix\Core\Router\Router;

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

        self::$_Router->get('movie_index', '/Movie', [ Controller\Movie::class, 'index']);
        self::$_Router->get('movie_show', '/Movie/{slug}-{id}', [ Controller\Movie::class, 'show'],
            ['slug' => '[a-zA-Z_]+', 'id' => '[0-9]+']);

        self::$_Router->get('streaming_index', '/Streaming', [Controller\Streaming::class, 'index']);
        self::$_Router->get('streaming_show', '/Streaming/{slug}-{id}', [Controller\Streaming::class, 'show'],
            ['slug' => '[a-zA-Z_]+', 'id' => '[0-9]+']);

        self::$_Router->get('admin_movie_index', '/Admin/Movie', [ Controller\Admin\AdminMovie::class, 'index']);
        self::$_Router->get('admin_movie_show', '/Admin/Movie/{slug}-{id}', [ Controller\Movie::class, 'show'],
            ['slug' => '[a-zA-Z_]+', 'id' => '[0-9]+']);
        self::$_Router->get('admin_movie_edit', '/Admin/Movie/Edit/{id}', [ Controller\Admin\AdminMovie::class, 'edit'],
            ['id' => '[0-9]+']);


        try {
            // Controlle l'url et dirige vers le bon controller et methode si l'url match avec une route précédement créé
            // Sinon lève une exception
            $route = self::$_Router->resolve();
            $callback = $route->callback;
            $params = $route->matches;

            if (is_array($callback)) {
                $controller = new $callback[0]();
                $controller->action = $callback[1];
                $callback[0] = $controller;
            }
            // retourne une fonction defini par $callback en lui passant un tableau de paramètre $params
            return call_user_func_array($callback, $params);


        } catch (RouteNotFoundException $exception) {
            // TODO Créer les pages d'erreur
            return "Erreur : " . $exception->getMessage();
        }

    }
}
