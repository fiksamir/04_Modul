<?php
/**
 * Created by PhpStorm.
 * User: ADAM
 * Date: 18.10.2016
 * Time: 18:44
 */

class Lang {
    
    protected static $data;
    
    public static function  load($lang_code) {
        $lang_file_path  = ROOT.DS.'lang'.DS.strtolower($lang_code).'.php';
        
        if ($lang_file_path) {
            self::$data = include ($lang_file_path);
        } else {
            throw new Exception('Lang path not found: '. $lang_file_path);
        }
    }
    
    public static function get ($key, $default_value = '') {
        return isset(self::$data[strtolower($key)]) ? self::$data[strtolower($key)] : $default_value;
    }
}