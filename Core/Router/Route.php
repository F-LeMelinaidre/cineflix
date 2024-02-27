<?php

namespace Cineflix\Core\Router;

/**
 * Class Route représente une route
 * Exemple de route sans le nom de domaine: /pages
 *
 * Route avec paramètre exemple: /pages/show.php?id=1
 *
 * On représente le paramètre ainsi: /pages/:id
 *
 * $path = chemin de la route, sans les / en debut et fin
 * $params = tableau des paramètres de la route ['controller' => ..., 'action' => ..., 'params' => ['nom' => 'regex']]
 * $matches
 *
 * TODO gestion des paramètres controller action
 */

class Route
{

    private $path;

    private array $params;
    private array $require = [];
    private array $matches;

    public function __construct($path, $params)
    {
        $this->path = trim($path, '/');

        $this->params = array_diff_key($params, ['require' => null]);

        if(isset($params['require'])) $this->require = $params['require'];
    }

    /**
     * Recherche de correspondance de l'url courante avec la route
     *
     * preg_replace_callback() est utilisé pour créer l'expression régulière utilisé dans la condition if(!preg_match(...))
     * On recherche dans le path si il y a des paramètres d'attendu.
     *  exemple:
     *  Route defini avec la function get() de la class Router get('/pages/:id',['require' => ['id' => '[0-9]+']],pages.show)
     *
     * Si le path contient des paramètres, défini tel que :id,
     * On appel la fonction paramMatch pour remplacer le nom du paramètre, exemple :id,
     * par l'expression regulière correspondant, defini par ['require' => ['id' => '[0-9]+']]
     *
     * Ainsi l'expression régulière pour la route /pages/:id sera celle-ci /pages/([0+9]+)
     *
     *  1er paramètre une expression réguilière
     *  :([\w])+ recherche \w n'importe quel caractère alpha numérique + plusieurs fois après :
     *  2nd paramètre Appel la function paramMatch() lorsqu'il y a match de :([\w])+
     *  3ème la chaine de caratère dans la quelle le remplacement s'effectue
     *
     * Condition if(preg_match(...)) renvoi true si l'url courante match avec la route, par defaut la méthode renvoi false
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
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'requiredMatch'], $this->path);
        $reg = "#^$path$#i"; //i prend en concidération majuscule et minuscule

        $return = (preg_match($reg, $url, $matches))? true : false;

        array_shift($matches);
        $this->matches = $matches;

        //echo 'Class: '.__CLASS__.'<br>Function: '.__FUNCTION__.'<br>Line: '.__LINE__.'<br>Path: '.$path.'<br>Match = '.var_export($return, TRUE).'<br><br>';
        return $return;
    }

    /**
     * Retourne l'expression régulière défini et correspondant à la route matché
     * exemple:
     * Route defini avec la function get() de la class Router get('/pages/:id',['require' => ['id' => '[0-9]+']],pages.show)
     *
     * @param $match // nom du paramètre correspondant à la clé du tableau require pour récupérer le regex, si défini, sinon regex par defaut ([^\]+)
     * @return void
     */
    private function requiredMatch($match):string
    {
        return (isset($this->require[$match[1]]))? '('.$this->require[$match[1]].')' : '([^\]+)';
    }

    /**
     * @return void
     */
    public function call():array
    {
        return $this->params;
    }

    public function getUrl(array $params):string
    {
        $path = $this->path;

        foreach ($params as $key => $val) {
            $path = str_replace(":$key", $val, $path);
        }
        return '/'.$path;
    }
}
