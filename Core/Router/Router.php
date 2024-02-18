<?php

namespace Cineflix\Core\Router;

use Cineflix\Core\Router\RouterException;
class Router
{

    private string $url = '';
    private array $routes = [];

    public function __construct()
    {
        if(isset($_GET['uri'])) $this->url = $_GET['uri'];
    }
    public function get(string $path, callable $callable):void
    {
        $route = new Route($path, $callable);
        $this->routes['GET'][] = $route;
    }
    public function post(string $path, callable $callable):void
    {
        $route = new Route($path, $callable);
        $this->routes['POST'][] = $route;
    }

    public function run() {
        $req_method = $_SERVER['REQUEST_METHOD'];



        foreach ($this->routes[$req_method] as $route) {
            if($route->match($this->url)) {
                return $route->call();
            }
        }
    }
}