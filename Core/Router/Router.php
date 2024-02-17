<?php

namespace Cineflix\Core\Router;

class Router
{

    private string $url;
    private array $route = [];

    public function __construct($url) {
        $this->url = $url;
    }
    public function get(string $path, callable $callable, string $name)
    {

    }
}