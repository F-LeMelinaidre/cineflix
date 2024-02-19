<?php

namespace Cineflix\Core\Router;

use Psr\Http\Message\MessageInterface;

/**
 * Class Route représente une route
 * Exemple de route sans le nom de domaine: /pages
 *
 * Route avec paramètre exemple: pages/show.php?id=1
 *
 * On représente le paramètre ainsi: /pages/:id
 *
 * $path = chemin de la route, sans les / en debut et fin
 * $params = tableau des paramètres de la route ['controller' => ..., 'action' => ..., 'params' => ['nom' => 'regex']]
 * $matches
 */

class Route
{

    private $path;
    private array $params;
    private array $matches;

    public function __construct($path, $params)
    {
        $this->path = trim($path, '/');
        $this->params = $params;
    }

    /**
     * Recherche de correspondance de l'url courante avec la route
     *
     * preg_replace_callback() est utilisé pour créer l'expression régulière utilisé dans la condition if(!preg_match(...))
     * On recherche dans le path si il y a des paramètres d'attendu.
     *  exemple:
     *  Route defini avec la function get() de la class Router get('/pages/:id',['params' => ['id' => '[0-9]+']],pages.show)
     *
     * Si le path, la route defini doit contenir des paramètres tel que :id,
     * on appel la fonction paramMatch pour remplacer le nom du paramètre, exemple :id,
     * par l'expression regulière correspondant, defini par ['params' => ['id' => '[0-9]+']]
     *
     * Ainsi l'expression régulière pour la route /pages/:id sera celle-ci /pages/[0+9]+
     *
     *  1er paramètre une expression réguilière
     *  :([\w])+ recherche \w n'importe quel caractère alpha numérique + plusieurs fois après :
     *  2nd paramètre Appel la function paramMatch() lorsqu'il y a match :([\w])+
     *  3ème la chaine de caratère dans la quelle le remplacement s'effectue
     *
     * Condition if(!preg_match(...)) renvoi false si l'url courante ne match pas avec la route
     *  1er paramètre $reg expression regulière représentant le chemin $path
     *  2nd url courante à tester avec path
     *  3ème $matches tableau retourné, contenant les éléments de l'url suivante les expressions régulières, si elle match avec le chemin
     *
     *  @param $url // url courante sans les / du debut et de fin
     *  @return bool
     */
    public function match($url): bool
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $reg = "#^$path$#i"; //i prend en concidération majuscule et minuscule



        if(!preg_match($reg, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;

        return true;
    }

    /**
     * Retourne l'expression régulière défini et correspondant à la route matché
     * exemple:
     * Route defini avec la function get() de la class Router get('/pages/:id',['params' => ['id' => '[0-9]+']],pages.show)
     *
     *
     * @param $match
     * @return void
     */
    private function paramMatch($match) {
        //'([^\]+)'
    }

    /**
     * @return void
     */
    public function call() {

    }
}