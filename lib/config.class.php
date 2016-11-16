<?php
/**
 * Created by PhpStorm.
 * User: ADAM
 * Date: 05.10.2016
 * Time: 1:31
 */

class Config {
    protected static $settings = array();
    
    public static function get($key) {
        return isset(self::$settings[$key]) ? self::$settings[$key] : NULL;
    }
    
    public static function set($key, $value) {
        self::$settings[$key] = $value;
    }
}