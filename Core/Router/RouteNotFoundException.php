<?php

namespace Cineflix\Core\Router;

use Exception;

class RouteNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}