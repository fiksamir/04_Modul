<?php
/**
 * Created by PhpStorm.
 * User: ADAM
 * Date: 05.10.2016
 * Time: 16:39
 */

class View {

    protected $data;
    protected $path;

    protected static function getDefaultViewPath() {
        $router = App::getRouter();
        if (!$router) {
            return false;
        }
        $controller_dir = $router->getController();
        $template_name = $router-> getMethodPrefix().$router->getAction().'.html';
        return VIEW_PATH.DS.$controller_dir.DS.$template_name;
    }

    public function __construct($data = array(),$path = null)
    {
        if (!$path) {
            $path = self::getDefaultViewPath();
        }
        if (!file_exists($path)) {
            throw new Exception ('Template file is not found in path '.$path);
        }
        $this->data = $data;
        $this->path = $path;
    }
    
    public function render() {
        $data = $this->data;
        
        // Turn on buffer
        ob_start();
        include($this->path);
        $content = ob_get_clean();
        
        return $content;
    }
}