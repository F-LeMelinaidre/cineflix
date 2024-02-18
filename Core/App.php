<?php

namespace Cineflix\Core;


use Cineflix\Core\Router\Router;

require '../vendor/autoload.php';


class App
{

    public static function load():void
    {
        $router = new Router();

        $router->get('/', function(){ echo 'Accueil'; });
        $router->get('/Auth', function(){ echo 'Afficher Auth'; });
        $router->get('/movies', function(){ echo 'Afficher les films'; });
        $router->get('/profil', function(){ echo 'Afficher le profil'; });
        $router->get('/Streams', function(){ echo 'Afficher les streams'; });
        $router->get('/User', function(){ echo 'Afficher User'; });
        $router->run();

        echo '<p>Class: ' . __CLASS__ . ' | Function: ' . __FUNCTION__ . '</p>';
    }


}
