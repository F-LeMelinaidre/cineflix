<?php
// Point d'entrée de l'application

session_start();

// défini le fuseau horaire de site
date_default_timezone_set('Europe/Paris');

// pour affichage du temps de generation de page
define('DEBUG_TIME', microtime(true));

// Appel La function load de la class AppController, qui gère l'ensemble de l'appli
require ("../App/AppController.php");
$app = new \Cineflix\App\AppController();

echo $app->run();
