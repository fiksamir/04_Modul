<?php
/**
 * Created by PhpStorm.
 * User: ADAM
 * Date: 04.10.2016
 * Time: 18:41
 */

define ('DS', DIRECTORY_SEPARATOR);
define ('ROOT', dirname(dirname(__FILE__)));
define ('VIEW_PATH', ROOT.DS.'views');

require_once (ROOT.DS.'lib'.DS.'init.php');

//$router = new Router($_SERVER['REQUEST_URI']);
//
//echo "<pre>";
//print_r('Route: '. $router->getRoute() . PHP_EOL);
//print_r('Language: '. $router->getLanguage() . PHP_EOL);
//print_r('Controller: '. $router->getController() . PHP_EOL);
//print_r('Action to be called: '. $router->getMethodPrefix() . $router->getAction() . PHP_EOL);
//echo "Param: ";
//print_r($router->getParams());

session_start();

App::run($_SERVER['REQUEST_URI']);

