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

        $router->get('/',
                         [
                             'controller' => 'home',
                             'action' => 'index'
                         ],
                         'home.index'
                    );
        
        $router->get('/Auth/signin',
                         [
                             'controller' => 'Auth',
                             'action' => 'signin'
                         ],
                         'auth.signin'
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
                             'controller' => 'movies',
                             'action' => 'index'
                         ],
                         'movies.index'
                    );
        
        $router->get('/Movies/:slug-:id',
                     [
                             'controller' => 'movies',
                             'action' => 'show',
                             'params' => [
                                             'slug' => '[a-z\-0-9]+',
                                             'id' => '[0-9]+'
                                         ]
                         ],
                        'movies.show'
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
        
        $router->get('/User',
                         [
                             'controller' => 'user',
                             'action' => 'index'
                         ],
                         'user.index'
                    );
        
        $router->run();

        echo '<p>Class: ' . __CLASS__ . ' | Function: ' . __FUNCTION__ . '</p>';
    }


}
