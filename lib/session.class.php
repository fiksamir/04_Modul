<?php
/**
 * Created by PhpStorm.
 * User: ADAM
 * Date: 19.10.2016
 * Time: 15:15
 */

class Session {

    // cообщение каторое необходимо выдать
    protected static $flash_message;

    /**
     * @param $message
     */
    public static function  setFlash($message) {
        self::$flash_message = $message;
    }

    // проверка наличия сообщения
    public static function hasFlash() {
        return !is_null(self::$flash_message);
    }

    // вывести текущее сообщеие и очистить его
    public static function flash(){
        echo self::$flash_message;
        self::$flash_message = null;
    }
    
    public static function set($key, $value) {
        $_SESSION[$key]=$value;
    }
    
    public static function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
    
    public static function delete($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    public static function destroy() {
        session_destroy();
    }

}