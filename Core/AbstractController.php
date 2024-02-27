<?php

namespace Cineflix\Core;

use Cineflix\App\AppController;
use Cineflix\Core\Router\Router;

class AbstractController

{


    protected static Router $_Router;
    protected string $layout = 'main';
    protected string $title_page = AppController::APP_NAME;
    // APP_NAME est défini dans la Class AppController
    // $title_page correspond à la valeur de l'élément <title></title>
    // Peux être complèté ou modifié directement dans le controller de la page

    protected string $page_id;
    // Définir l'id de l'element <main></main>
    protected bool $header = true;

    private string $path_view;

    public function __construct()
    {
        self::$_Router = Router::getInstance();
        $this->path_view = AppController::$_Root.'/App/View/';
    }
    /**
     * @param string $view
     * @param array $data
     * @return void
     */
    public function render(string $contentView, array $data)
    {

        $this->setPageId($contentView);

        $layout = $this->layoutContent();
        $contentView = $this->renderOnlyView($contentView);
        $layout = str_replace('{{content}}', $contentView, $layout);

        ob_start();
        extract($data);
        include_once($this->path_view."Base/index.php");
        $view = ob_get_clean();


        $view = str_replace('{{layout}}', $layout, $view);
        return $view;
    }
    protected function layoutContent()
    {
        ob_start();
        include_once $this->path_view."Layout/$this->layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view)
    {
        ob_start();
        include_once $this->path_view.str_replace('.', '/', $view).".php";
        return ob_get_clean();
    }
    /**
     * Transforme la syntax du path de la vue
     * exemple Home.index => HomeIndex
     * @param string $value
     * @return void
     */
    protected function setPageId(string $value):void
    {
        $page = explode('.',$value);
        $page = array_map('ucfirst', $page);
        $this->page_id = implode('',$page);
    }
}