<?php

session_start();

// pour affichage du temps de generation de page
define('DEBUG_TIME', microtime(true));

// défini le fuseau horaire de site
date_default_timezone_set('Europe/Paris');

// Appel La function load de la class App, qui gère l'ensemble de l'appli
require dirname(__DIR__) . "/cineflix/core/App.php";
\Core\App::load();

