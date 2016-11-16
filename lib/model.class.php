<?php
/**
 * Created by PhpStorm.
 * User: ADAM
 * Date: 19.10.2016
 * Time: 14:35
 */

class Model {
    
    protected $db;
    
    public function __construct() {
        $this->db = App::$db;
    }
}