<?php

namespace Cineflix\Core\Router;

class Route
{

    private $path;
    private $callable;
    private array $matches;

    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    public function match($url):bool
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^\]+)', $this->path);
        $regex = "#^$path$#i";

        if(!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;

        return true;
    }

    public function call() {
        if(is_string($this->callable)) {
            echo $this->callable;
        }
        return call_user_func_array($this->callable, $this->matches);
    }
}