<?php

namespace Cineflix\App\Controller;

use Cineflix\Core\AbstractController;

class ProfilController extends AbstractController
{
    // Voir si ce controller peux gerer l'historique films/streaming, les points
    // et autre infos à définir

    public function __construct()
    {
        echo '<br>Class: '.__CLASS__.'<br>';

    }

    public function index()
    {
        echo 'Function: '.__FUNCTION__.'<br>Line: '.__LINE__.'<br><br>';

    }

}
