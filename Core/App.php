<?php

namespace Cineflix\Core;


use Cineflix\Core\Router\Router;

require '../vendor/autoload.php';


class App
{

    public static function load():void
    {
        $router = new Router();

        $router->get('/', function(){ echo 'Home | index'; }, 'home.index');
        $router->get('/Auth/signin', function(){ echo 'Auth | signin'; }, 'auth.signin');
        $router->get('/Auth/signout', function(){ echo 'Auth | signout'; }, 'auth.signout');
        $router->get('/movies', function(){ echo 'Movie | index'; }, 'movies.index');
        $router->get('/profil', function(){ echo 'Profil | index'; }, 'profil.index');
        $router->get('/Streams', function(){ echo 'Streaming | index'; }, 'streaming.index');
        $router->get('/User', function(){ echo 'User | index'; }, 'user.index');
        $router->run();

        echo '<p>Class: ' . __CLASS__ . ' | Function: ' . __FUNCTION__ . '</p>';
    }


}
