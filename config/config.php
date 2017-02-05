<?php

Config::set('site_name', 'MVC Ajax');

Config::set('languages', array('en', 'id'));
Config::set('url_path', 'http://localhost/~ekobudi/mvc_ajax/'); //please change your localhost name
Config::set('image_path','img');
Config::set('image_thumb','img/thumb');

// Routes. Route name => method prefix
Config::set('routes', array(
    'default' => '',
));

//Default Route and Controller action
Config::set('default_route', 'default');
Config::set('default_language', 'en');
Config::set('default_controller', 'coas');
//Config::set('default_admin_controller', 'dashboards');
Config::set('default_action', 'index');
//end of default

//Database Configuration
Config::set('db.host', '127.0.0.1');
Config::set('db.user', 'root');
Config::set('db.password', 'masterkey');
Config::set('db.db_name', 'mvc_tutorial');
Config::set('db.db_port', '3306');
//end of Database Configuration

// Don't remove this salt key
//Encription Key     xy7dk6klndlhcot4j
Config::set('salt', 'jd7sj3sdkd964he7e');