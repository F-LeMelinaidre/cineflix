<?php

namespace Cineflix\Core;


use Cineflix\Core\Router\Router;

require '../vendor/autoload.php';


class App
{

    public static function load():void
    {
        // Création de l'ensemble des routes de l'application
        $router = new Router();

        $router->get('/', [],'home.index');
        $router->get('/Auth/signin', [], 'auth.signin');
        $router->get('/Auth/signout', [], 'auth.signout');
        $router->get('/movies', [], 'movies.index');
        $router->get('/movies/:slug-:id', ['params' => ['slug' => '[a-z\-0-9]+', 'id' => '[0-9]+']], 'movies.show');
        $router->get('/profil', [], 'profil.index');
        $router->get('/Streams', [], 'streaming.index');
        $router->get('/User', [], 'user.index');
        $router->run();

        echo '<p>Class: ' . __CLASS__ . ' | Function: ' . __FUNCTION__ . '</p>';
    }


}
