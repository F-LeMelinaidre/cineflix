<?php

namespace Cineflix\Core\Router;


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
     */
    public function post(string $name, string $path, array $callback, array $requirement = []):void
    {
        $this->add('POST', $name, $path, $callback, $requirement);
    }

    /**
     * @param string $name
     * @param string $path
     * @param array  $callback
     * @param bool   $methodGET
     *
     * @return void
     */
    public function ajax(string $name, string $path, array $callback, bool $methodGET = false):void
    {
        if($methodGET) {
            $this->add('AJAX', $name, $path.'{ajax}', $callback, ['ajax' => '\?(?:[a-zA-Z0-9_-]+=[a-zA-Z0-9!?_%\-]+(?:&[a-zA-Z0-9_-]+=[a-zA-Z0-9!?_%\-]+)*)']);
        } else {
            $this->add('AJAX', $name, $path, $callback);
        }

    }

    /**
     * Crée un Objet Route et l'ajout au tableau des routes indéxé par la $methode et son $name
     *
     * @param string $method
     * @param string $path
     * @param array $callback
     * @param array $requirement
     *
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
    public function resolve($method, $path): Route
    {


        if (str_starts_with($path, '/Ajax') && $method === 'GET') {
            $method = 'AJAX';
        }

        $routes = $this->routes[$method]; // Prend seulement les routes suivant la methode utilisé

        // parcours le tableau des routes et test l'url
        $matched = false;
        while(!empty($routes) && false === $matched ) {
            $route = array_shift($routes);

            if($route->match($path)) {

                $this->setSessionLastPageVisited($route);

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

    /**
     * @param \Cineflix\Core\Router\Route $route
     *
     * @return void
     */
    private function setSessionLastPageVisited(Route $route): void
    {
        if(!isset($_SESSION['nav_store'])) {
            $_SESSION['nav_store'] = [
                'last' => [
                    'name' => [],
                    'params'=> []
                ],
                'previous' => null
            ];
        }

        $last = $_SESSION['nav_store']['last'];

        $store['name'] = $route->getName();
        if(isset($route->matches)) $store['params'] = $route->matches;

        if(empty($last['name']) || $last['name'] !== $store['name']) {

            if(!empty($last['name'])) $_SESSION['nav_store']['previous'] = $last;

            $_SESSION['nav_store']['last'] = $store;
        }
    }

    /**
     * @return string
     */
    public function getLastPageVisited(): string
    {
        return $this->getUrl($_SESSION['nav_store']['previous']['name'], $_SESSION['nav_store']['previous']['params']);;
    }

}