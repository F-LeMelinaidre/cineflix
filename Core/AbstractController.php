<?php

namespace Cineflix\Core;

class AbstractController

{


    protected string $title_page = APP::APP_NAME;
    // APP_NAME est défini dans la Class App
    // $title_page correspond à la valeur de l'élément <title></title>
    // Peux être complèté ou modifié directement dans le controller de la page

    protected string $page_id;
    // Définir l'id de l'element <main></main>

    private string $path_view = WEBROOT.'/App/View/';

    /**
     * @param string $view
     * @param array $data
     * @return void
     */
    public function render(string $view, array $data)
    {
        $this->setPageId($view);

        ob_start();
        extract($data);

        require($this->path_view . str_replace('.', '/', $view) . '.php');

        // $content contient la view lier à l'action du controller
        $content = ob_get_clean();

        require($this->path_view. 'Base/index.php');
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