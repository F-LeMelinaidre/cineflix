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
 * Url appelé: url matchable de l'application
 * Nom de l'url: Pour la création des liens ( function getUrl())
 *
 * function run() Vérifie si l'url courante correspond à une url de l'application,
 * dans le tableau $routes indexé par le méthode (GET ou POST) puis par l'url'
 *
 * Après avoir instancié la class dans AppController,
 * ajouter les routes en utilisant les fonctions get() ou post()
 *
 * le tableau $routes est utilisé pour router l'url courante
 * le tableau $routes_name est utilisé pour créer le lien correspondant à une route
 */
class Router
{

    private static $instance; // Stock l'instance de la class Router
    private array $routes = []; // Stock les routes par Méthode
    private array $routes_name = []; // Stock les routes par nom

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
     * @param string $path
     * @param array $params
     * @param string $name
     * @return Route
     */
    public function get(string $path, array $params, string $name = null):void
    {
        $this->add($path, $params, $name, 'GET');
    }

    /**
     * Ajout des routes de methode POST
     * @param string $path
     * @param array $params
     * @param string|null $name
     * @return Route
     */
    public function post(string $path, array $params, string $name = null):void
    {
        $this->add($path, $params, $name, 'POST');
    }

    /**
     * Crée un Objet Route et l'ajout au tableau des routes indéxé par la $methode
     * @param string $path
     * @param string $name
     * @param string $method
     * @return Route
     */
    private function add(string $path, array $params, string $name, string $method): void
    {
        $route = new Route($path, $params);

        // On ajoute l'objet route au tableau des routes
        $this->routes[$method][] = $route;

        // Si le nom de la route est null, on lui attribut le path comme nom en remplaçant le / par un point
        if(is_null($name)) $name = str_replace('/', '.',$path);

        // Ajout de l'objet route au tableau $routes_name
        $this->routes_name[$name] = $route;
    }

    /**
     * Génère l'url en fonction de son nom et paramtères
     * Appel la fonction getUrl de l'objet route stocké dans le tableau $routes_name, indexé par son nom,
     * $params est facultatif, il contient la paramètre $_Get passé dans l'url
     *
     * @param string $name
     * @param array $params
     * @return string url
     */
    public function getUrl(string $name, array $params = []):string
    {
        // TODO Creer une Exception type info bulle
        return (isset($this->routes_name[$name]))? $this->routes_name[$name]->getUrl($params) : '';
    }

    /**
     * Vérifie si l'url courante correspond à une url du tableau $routes
     * @return Cineflix\AppController\Controller
     */
    public function routeMatched():Route
    {
        // Stock tous se qu'il y a après le nom de domaine
        $url = (isset($_GET['uri']))? $_GET['uri'] : '';
        // Stock la méthode utilisé. Get ou Post
        $req_method = $_SERVER['REQUEST_METHOD'];

        // Récupère et stock tous les routes correspondant à la méthode actuel
        $routes = $this->routes[$req_method];

        // Parcours le tableau routes contenant les objets route
        // Si la méthode match() trouve une correspondante
        // On attribute l'objet route a $this->route
        $nb = count($routes) - 1;
        $i = 0;
        while($i <= $nb && !isset($route)) {

            if($routes[$i]->match($url)) {
                $route = $routes[$i]->call();
            }

            $i++;
        }

        // si aucune route ne correspond on lève une exception
        if(!isset($route)) {
            throw new RouteNotFoundException("Aucune route correspondante n'a été trouvée");
        }

        return $route;

    }

}