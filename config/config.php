<?php
/**
 * Created by PhpStorm.
 * User: ADAM
 * Date: 05.10.2016
 * Time: 1:39
 */

Config::set('site_name','Your Site Name');

Config::set('languages', array (
    'en',
    'fr',
    )
);

//Routes. Route name => method prefix
Config::set('routes',array(
    'default' => '',
    'admin' => 'admin_',
    )
);

Config::set('default_route','default');
Config::set('default_language','en');
Config::set('default_controller','pages');
Config::set('default_action','index');

Config::set('db.host','localhost');
Config::set('db.user','root');
Config::set('db.password','');
Config::set('db.db_name','mvc');

Config::set('salt','jd7sj3sdkd964he7e');