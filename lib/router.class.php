<?php

class Router{

    protected $uri;

    protected $controller;

    //protected $dasboard_controller;

    protected $action;

    protected $params;

    protected $route;

    protected $method_prefix;

    protected $language;

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getMethodPrefix()
    {
        return $this->method_prefix;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    public function __construct($uri){

        //print_r($uri);
        $this->url = (isset($_GET['request']) ? explode('/', $_GET['request']) : null);

        //print_r($_GET['request']);
        $path_parts = $this->url;

        //print_r($path_parts);*/
        //pri
        /*$path_url = urldecode(trim($uri, './'));

        //print_r($path_url);
        $this->uri = $path_url;*/

        // Get defaults
        $routes = Config::get('routes');
        $this->route = Config::get('default_route');
        $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
        $this->language = Config::get('default_language');
        $this->controller = Config::get('default_controller');
        //$this->dasboard_controller = Config::get('default_admin_controller');
        $this->action = Config::get('default_action');

        //$uri_parth = explode('?', $this->uri[3]);

        // Get path like /lng/controller/action/param1/param2/.../...
        //$path = $uri_parts;

        //$path_parts = $uri_parth; //explode('/', $uri_parth);

        //print_r(explode('/',$path));

        if ( count($path_parts) ){

            // Get route or language at first element
            if ( in_array(strtolower(current($path_parts)), array_keys($routes)) ){
                $this->route = strtolower(current($path_parts));
                $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
                array_shift($path_parts);
            } elseif ( in_array(strtolower(current($path_parts)), Config::get('languages')) ){
                $this->language = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            // Get controller - next element of array
            if ( current($path_parts) ){
                //print_r($path_parts[3]);
                $this->controller = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            /*if ( current($path_parts) ){
                //print_r($path_parts[3]);
                $this->dasboard_controller = strtolower(current($path_parts));
                array_shift($path_parts);
            }*/

            // Get action
            if ( current($path_parts) ){
                $this->action = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            // Get params - all the rest
            $this->params = $path_parts;

        }

    }

    public static function redirect($location){
        header("Location: $location");
    }

}