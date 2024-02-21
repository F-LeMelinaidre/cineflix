<?php

namespace Cineflix\Core;


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

class App
{
    const APP_NAME = 'Cinéflix';

    public static function load():void
    {
        // Création de l'ensemble des routes de l'application
        $router = Router::getInstance();

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
                             'controller' => 'movie',
                             'action' => 'index'
                         ],
                         'movies.index'
                    );
        
        $router->get('/Movie/:slug-:id',
                         [
                             'controller' => 'movie',
                             'action' => 'show',
                             'params' => [
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
                'params' => [
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
        
        $router->run();
        
    }


}
