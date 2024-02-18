<?php

namespace Cineflix\Core\Router;

use Cineflix\Core\Router\RouterException;
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
     * @param string $path
     * @param callable $callable
     * @param string $name
     * @return Route
     */
    public function get(string $path, callable $callable, string $name):Route
    {
        return $this->add($path, $callable, $name, 'GET');
    }
    public function post(string $path, callable $callable, string $name):Route
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    /**
     * @param string $path
     * @param callable $callable
     * @param string $name
     * @param string $method
     * @return Route
     */
    private function add(string $path, callable $callable, string $name, string $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;

        return $route;
    }

    /**
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