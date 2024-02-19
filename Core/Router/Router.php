<?php

namespace Cineflix\Core\Router;

/**
 * $url = url courante
 * $routes = tableau des routes de l'application
 *
 * function add() stock la route dans le tableau routes, suivant la fonction parente utilisé.
 * function get() pour les méthode $_GET exemple: get('/pages/:id',['params' => ['id' => '[0-9]+']],pages.show)
 * function post() pour les méthode $_POST
 * Schéma du tableau route:
 *
 * $routes = {
 *     'GET'  => [url appelé, nom de l'url],
 *     'POST' => [url appelé, nom de l'url],
 * };
 *
 *  l'intérêt d'indexer les routes par GET ou POST est de réduire les tests, ou la récupération d'url suivant la méthode
 *  sur un tableau qui pourrait en contenir un grand nombre.
 *
 * Url appelé: url de l'application matchable
 * Nom de l'url: Pour la création des url des liens ( function url())
 *
 * function run() Vérifie si l'url courante correspond à une url de l'application
 *
 * Après avoir instancié la class au niveau de l'entrée de l'application,
 * ajouter les routes en utilisant les fonctions get() ou post()
 *
 */
class Router
{

    private string $url = '';
    private array $routes = [];
    private array $routes_name = [];

    public function __construct()
    {
        if(isset($_GET['uri'])) $this->url = $_GET['uri'];
    }

    /**
     * Ajout des routes de methode GET
     * @param string $path
     * @param array $params
     * @param string $name
     * @return Route
     */
    public function get(string $path, array $params, string $name = null):Route
    {
        return $this->add($path, $params, $name, 'GET');
    }

    /**
     * Ajout des routes de methode POST
     * @param string $path
     * @param array $params
     * @param string|null $name
     * @return Route
     */
    public function post(string $path, array $params, string $name = null):Route
    {
        return $this->add($path, $params, $name, 'POST');
    }

    /**
     * Ajout des routes definient par les function get() et post() au tableau $routes
     * @param string $path
     * @param string $name
     * @param string $method
     * @return Route
     */
    private function add(string $path, array $params, string $name, string $method):Route
    {
        $route = new Route($path, $params);
        $this->routes[$method][] = $route;

        if($name) {
            $this->routes_name[$name] = $route;
        }
        return $route;
    }

    /**
     * @param string $name
     * @param array $params
     * @return void
     */
    public function url(string $name)
    {
        //TODO ajouter getUrl dans la Class Route
    }

    /**
     * Vérifie si l'url courante correspond à une url du tableau $routes
     * TODO créer les exceptions
     * @return void
     */
    public function run() {
        $req_method = $_SERVER['REQUEST_METHOD'];



        foreach ($this->routes[$req_method] as $route) {
            if($route->match($this->url)) {
                return $route->call();
            }
        }
    }
}