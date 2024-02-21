<?php
// Point d'entrée de l'application

session_start();

// défini le fuseau horaire de site
date_default_timezone_set('Europe/Paris');

// pour affichage du temps de generation de page
define('DEBUG_TIME', microtime(true));

define( 'ROOT', str_replace( 'index.php', '', $_SERVER['SCRIPT_NAME'] ) );
define( 'WEBROOT', $_SERVER['DOCUMENT_ROOT'] );

// Appel La function load de la class App, qui gère l'ensemble de l'appli

require WEBROOT.'/Core/App.php'; // Corrigez le chemin relatif

\Cineflix\Core\App::load();
