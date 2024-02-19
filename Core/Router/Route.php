<?php

namespace Cineflix\Core\Router;

use Psr\Http\Message\MessageInterface;

/**
 * Class Route représente une route
 * Exemple de route sans le nom de domaine: /pages
 *
 * Route avec paramètre exemple: pages/index.php?id=1
 *
 * On représente le paramètre ainsi: /pages/:id
 *
 * $path = chemin de la route, sans les / en debut et fin
 * $params =
 * $matches
 */

class Route
{

    private $path;
    private array $params;
    private array $matches;

    public function __construct($path)
    {
        $this->path = trim($path, '/');
    }

    /**
     * @param $url // url courante sans les / du debut et de fin
     * @return bool
     *
     * preg_replace_callback est utilisé:
     *  1er paramètre une expression réguilière, qui remplace les paramètres passé dans l'url
     *  2bd paramètre Le Callback appel une fonction
     *  3ème la chaine de caratère dans la quelle le remplacement s'effectue
     *
     * Condition if(!preg_match()) renvoi false si l'url courante ne match pas avec la route
     *  1er paramètre $reg expression regulière représentant le chemin $path
     *  2nd url courante à tester avec path
     *  3ème $matches tableau retourné, contenant les éléments de l'url, si elle match avec le chemin
     */
    public function match($url):bool
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $reg = "#^$path$#i";



        if(!preg_match($reg, $url, $matches)) {
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