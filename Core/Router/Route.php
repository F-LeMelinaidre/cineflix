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

    private string $name;
    private string $path;
    public array $callback;
    private array $requirement;
    private array $requirementKeys;
    private array $matches;

    public function __construct(string $name, string $path, array $callback, array $requirement = [])
    {
        $this->name        = $name;
        $this->path        = trim($path, '/');
        $this->callback    = $callback;
        $this->requirement = $requirement;
        $this->requirementKeys = array_keys($requirement);
    }

    /**
     * Recherche de correspondance de l'url courante avec la route
     *
     * preg_replace_callback() est utilisé pour créer l'expression régulière utilisé dans la condition if(!preg_match(...))
     *
     *   1er paramètre une expression réguilière
     *   #{([\w])+}# recherche \w n'importe quel caractère alpha numérique + plusieurs fois entre { }
     *
     *   2nd paramètre Appel la function paramMatch() lorsqu'il y a match de #{([\w])+}#
     *
     *   3ème la chaine de caratère dans la quelle le remplacement s'effectue
     *
     *
     * On recherche dans le path si il y a des paramètres d'attendu.
     *  exemple:
     *  Route defini avec la function get() de la class Router get('pages_show', '/pages/{id}', [Page::class, 'show'], ['id' => '[0-9]+'])
     *
     * Si le path contient des paramètres, défini tel que {id},
     * On appel la fonction paramMatch pour remplacer le nom du paramètre, exemple {id},
     * par l'expression regulière correspondant, defini par $requirement = ['id' => '[0-9]+']
     *
     * Ainsi l'expression régulière pour la route /pages/{id} sera celle-ci /pages/([0+9]+)
     *
     *
     * Condition if(preg_match(...)) renvoi true si l'url courante match avec la route, par defaut la méthode renvoi false
     *  1er paramètre $reg expression regulière représentant le chemin $path
     *  2nd url courante à tester avec path
     *  3ème $matches tableau retourné, contenant les paramètres dans l'url suivant les expressions régulières, si elle match avec le chemin
     *
     *  @param $url // url courante sans les / du debut et de fin
     *
     *  @return bool
     */
    public function match($url): bool
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#{([\w]+)}#', [$this, 'requiredMatch'], $this->path);
        $reg = "#^$path$#i"; //i prend en concidération majuscule et minuscule

        $result = preg_match($reg, $url, $matches);

        // Si l'url contient des paramètres matché, on réassocie les clés au valeurs matché
        if(!empty($matches)) {
            array_shift($matches);
            $this->matches = array_combine($this->requirementKeys, $matches);
        }

        return $result;
    }

    /**
     * Retourne l'expression régulière défini et correspondant à la route matché
     * exemple:
     * Route defini avec la function get() de la class Router get('pages_show', '/pages/{id}', [Page::class, 'show'], ['id' => '[0-9]+'])
     *
     * @param $match // nom du paramètre correspondant à la clé du tableau require pour récupérer le regex, si défini, sinon regex par defaut ([^\]+)
     * @return void
     */
    private function requiredMatch($match):string
    {
        return (isset($this->requirement[$match[1]]))? '('.$this->requirement[$match[1]].')' : '([^\]+)';
    }

    /**
     * @return
     */
    public function call():self
    {
        return $this;
    }

    /**
     * @param array $params
     *
     * @return string
     */
    public function getUrl(array $params):string
    {
        $path = $this->path;

        foreach ($params as $key => $val) {
            $path = str_replace(":$key", $val, $path);
        }
        return '/'.$path;
    }

}
