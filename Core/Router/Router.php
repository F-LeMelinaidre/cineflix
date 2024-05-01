<?php

namespace Cineflix\Core\Router;

use Cineflix\App\AppController;
use Cineflix\Core\Router\Route;
use Exception;

/**
 * $path = url courante
 * $routes = tableau des routes de l'application
 *
 * function add() stock la route dans le tableau routes, suivant la fonction parente utilisé. get() ou post()
 * function get() pour les méthode $_GET exemple: get('pages_show', '/pages/{id}', [Page::class, 'show'], ['id' => '[0-9]+'])
 * function post() pour les méthode $_POST
 * Schéma du tableau route:
 *
 * $routes = {
 *     'GET'  => [nom_route => class Route(nom, path, callback, requirement)],
 *     'POST' => [nom_route => class Route(nom, path, callback, requirement)],
 * };
 *
 *  l'intérêt d'indexer les routes par GET ou POST est de réduire les tests, ou la récupération d'url suivant la méthode
 *  sur un tableau qui pourrait en contenir un grand nombre.
 *
 *  le nom de route est utiliser comme parametre de getUrl() pour créer l'url des liens
 */
class Router
{

    private static $instance; // Stock l'instance de la class Router
    private array $routes = []; // Stock les routes par Méthode et nom

    /**
     * Récupère l'instance de Router ou en créé une si elle ne l'est pas
     * @return Router
     */
    public static function getInstance() {
        if(!self::$instance) self::$instance = new Router();

        return self::$instance;
    }

    /**
     * Ajout des routes de methode GET
     *
     * @param string $path
     * @param array  $callback
     * @param array  $requirement
     *
     * @return Route
     */
    public function get(string $name, string $path, array $callback, array $requirement = []):void
    {
        $this->add('GET', $name, $path, $callback, $requirement);
    }

    /**
     * Ajout des routes de methode POST
     *
     * @param string $path
     * @param array $callback
     * @param array $requirement
     *
     * @return Route
     */
    public function post(string $name, string $path, array $callback, array $requirement = []):void
    {
        $this->add('POST', $name, $path, $callback, $requirement);
    }

    public function ajax(string $name, string $path, array $callback):void
    {
        $this->add('AJAX', $name, $path.'{ajax}', $callback, ['ajax' => '\?(?:[a-zA-Z0-9_-]+=[a-zA-Z0-9_-]+(?:&[a-zA-Z0-9_-]+=[a-zA-Z0-9_-]+)*)']);
    }

    /**
     * Crée un Objet Route et l'ajout au tableau des routes indéxé par la $methode et son $name
     *
     * @param string $method
     * @param string $path
     * @param array $callback
     * @param array $requirement
     *
     * @return Route
     */
    private function add(string $method, string $name, string $path, array $callback, array $requirement = []): void
    {
        // On créé un objet Route et on l'ajoute au tableau des routes
        $route = new Route($name, $path, $callback, $requirement);
        $this->routes[$method][$name] = $route;
    }

    /**
     * Génère l'url en fonction de son nom et paramtères
     * Appel la fonction getUrl de l'objet route stocké dans $routes, indexé par la methode et son nom,
     * $params est facultatif, il contient les paramètres $_Get à passé dans l'url
     *
     * @param string $name
     * @param array $params
     * @return string url
     */
    public function getUrl(string $name, array $params = []):string
    {
        // TODO Creer une Exception type info bulle
        if(isset($this->routes['GET'][$name])) {
            $route = $this->routes['GET'][$name]->getUrl($params);

        } elseif (isset($this->routes['POST'][$name])) {
            $route = $this->routes['POST'][$name]->getUrl($params);

        } else {
            $route = '/';

        }
        return $route;
    }

    /**
     * @return \Cineflix\Core\Router\Route
     * @throws RouteNotFoundException
     */
    public function resolve(): Route
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/'; // url courant hors nom de domaine
        $method = $_SERVER['REQUEST_METHOD']; // methode POST ou GET

        if (str_starts_with($path, '/Ajax') && $method === 'GET') {
            $method = 'AJAX';
        }

        $routes = $this->routes[$method]; // Prend seulement les routes suivant la methode utilisé

        // parcours le tableau des routes et test l'url
        $matched = false;
        while(!empty($routes) && false === $matched ) {
            $route = array_shift($routes);

            if($route->match($path)) {
                $matched = true;
            } else {
                unset($route);
            }

        }
        // si aucune route ne correspond on lève une exception
        if(!isset($route)) {
            throw new RouteNotFoundException("Aucune route correspondante n'a été trouvée");
        }

        return $route;
    }

}