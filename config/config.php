<?php
/**
 * home file with application settings /
 * stores the name of the site /
 * stores the languages array /
 * stores the array of roles /
 * stores default settings for DB connection (host,user,password,db_name) /
 * default: router, language, controller, action /
 * contains salt for passwords /
 */
Config::set('site_name','4_news');

// array of languages
Config::set(
    'languages', array (
        'rus',
        'ukr',
        'eng'
    )
);

// array of roles
Config::set(
    'routes', array (
        'default'   => '',
        'admin'     => 'admin_',
        'user'      => 'user_',
        'moderator' => 'moderator_',
    )
);

// Default sets for all site
Config::set('default_router'    ,'default');
Config::set('default_language'  ,'rus');
// Config::set('default_controller','news'); TODONE change default controller 
Config::set('default_controller','home');
Config::set('default_action'    ,'index'); 

// DataBase config
Config::set('db.host'    ,'localhost');
Config::set('db.user'    ,'root');
Config::set('db.password','');
Config::set('db.name'    ,'4_news');

// slat makes the password more complex
Config::set('salt', 'dfnk346jg4jg36gj4h5g6kg5kjg3');
