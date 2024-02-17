<?php

session_start();
// Point d'entrée de l'application

// pour affichage du temps de generation de page
define('DEBUG_TIME', microtime(true));

// défini le fuseau horaire de site
date_default_timezone_set('Europe/Paris');

// Appel La function load de la class App, qui gère l'ensemble de l'appli

require '../Core/App.php';

\Cineflix\Core\App::load();