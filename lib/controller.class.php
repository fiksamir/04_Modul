<?php
/**
 * Created by PhpStorm.
 * User: ADAM
 * Date: 05.10.2016
 * Time: 16:07
 */

class Controller {
    protected $data;
    protected $model;
    protected $params;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->parents;
    }
    
    public function __construct($data = array())
    {
        $this->data = $data;
        $this->params = App::getRouter()->getParams();
    }
}