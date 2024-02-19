<?php

namespace Cineflix\Core\Router;

use Psr\Http\Message\MessageInterface;

class Route
{

    private $path;
    private array $params;
    private array $matches;

    public function __construct($path)
    {
        $this->path = trim($path, '/');
    }

    public function match($url):bool
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";



        if(!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;

        return true;
    }

    private function paramMatch($match) {
        //'([^\]+)'
    }
    public function call() {

    }
}