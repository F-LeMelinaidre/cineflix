<?php

namespace Cineflix\Core;

class App {

    public static function load()
    {
        require '..\vendor\autoload.php';
        
        echo 'Class: ' . __CLASS__ . ' | Function: ' . __FUNCTION__;
    }
}