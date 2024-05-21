<?php

namespace Cineflix\Core;

use Cineflix\App\AppController;
use Cineflix\Core\Router\Router;

abstract class AbstractController

{
    private array $js_lib = [];
    private array $script_block = [];
    private string $path_view;

    protected static Router $_Router;
    protected string $layout = 'main';

    // APP_NAME est défini dans la Class AppController
    // $title_page correspond à la valeur de l'élément <title></title>
    // Peux être complèté ou modifié directement dans le controller de la page
    protected string $title_page = AppController::APP_NAME;
    protected string $page_active = '';
    protected $dao;
    protected string $path_dao = "\\Cineflix\\App\\DAO\\";


    public string $action = '';

    public function __construct()
    {
        self::$_Router = Router::getInstance();

        $class_name = basename(get_called_class());

        if('Home' !== $class_name && 'Auth' !== $class_name) {
            $dao_class = $this->path_dao.$class_name.'Dao';
            $this->dao = new $dao_class();
        }


        $this->path_view = AppController::$_Root.'/App/View/';
    }

    /**
     * Cette methode est appelé dans la methode du controller fille dans un return
     * @param string $contentView Nom du dossier et nom du fichier ex: Home.index
     * @param array $data Tableau de datas à afficher dans la vue
     * @return string
     */
    public function render(string $contentView, array $data): string
    {

        // On recupère le layout
        $layout = $this->renderLayout($data);
        // On recupère la vue à la quelle on lui passe les datas à afficher
        $contentView = $this->renderView($contentView, $data);

        // On remplace la chaine de caractère {{content}} contenu dans le fichier layout récupéré en premier ($layout),
        // par le contenu du fichier  $contentView précédemment récupéré
        $layout = str_replace('{{content}}', $contentView, $layout);

        // Declaration de la variable $js_block pour l'ajout des scripts js
        if(!empty($this->js_lib)) $js_block = $this->js_lib;
        if(!empty($this->script_block)) $script_block = $this->script_block;

            // Enclenche la temporisation de sortie, quand elle est activé aucune sortie n'est effectué.
        // Stock en memoire le code du fichier appeler par include_once
        // Ce fichier est la base de la page, du code HTML
        ob_start();
        include_once($this->path_view."Base/index.view");
        $view = ob_get_clean();

        // Comme pour $layout on remplace {{layout}} dans le fichier de base de la page par $layout
        return str_replace('{{layout}}', $layout, $view);
    }


    /**
     * Enclenche la temporisation de sortie
     * Stock en memoire le code du fichier appeler par include_once
     * ob_get_clean renvoi le contenu du tampon en cas de succès (renvoi le code du fichier inclus)
     * @return string retourne le html contenu que l'on inserera entre les Tags <body> </body> du fichier Base/index.view
     */
    protected function renderLayout($data): string
    {
        ob_start();

        // Declaration de la variable active pour le lien du menu actif
        $active = $this->page_active;

        if(isset($data['footer'])) {
            $footer = $data['footer'];
        } else {
            $footer = '';
        }

        include_once $this->path_view."Layout/$this->layout.view";
        return ob_get_clean();
    }

    /**
     * Enclenche la temporisation de sortie
     * Stock en memoire le code du fichier appeler par include_once
     * ob_get_clean renvoi le contenu du tampon en cas de succès (renvoi le code du fichier inclus)
     * @return string retourne le html contenu que l'on inserera entre les Tags <main> </main> du fichier Layout/main.view ou Layout/auth.view ou Layout/admin.view
     */
    protected function renderView($view, $data): string
    {
        ob_start();
        // Transforme les clés en nom de variable et attribut a cette variable la valeur associé a la clé
        // Ce qui permet de de les appeler dans les vues
        extract($data);

        include_once $this->path_view.str_replace('.', '/', $view).".view";
        return ob_get_clean();
    }

    /**
     * @param ...$scripts
     * Formatage de la chaine et ajout du chemin du fichier ou lien js
     * à la lib $js
     * @return void
     */
    protected function addJavascript(string $path, ?string $type = null): void
    {
        if(!str_starts_with($path,'https://') && !str_starts_with($path,'/public/')) {
            $path = '/public/'.$path;
        }

        $js = [ 'path' => $path,
                'type' => $type];

        array_push($this->js_lib,$js);
    }

    protected function addScriptBlock(string $script): void
    {
        $block = <<<SCRIPT
                    <script>
                        $script
                    </script>
                SCRIPT;

        array_push($this->script_block,$block);
    }
}