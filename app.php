<?php


class Application
{
    public $uri;

    public function __construct()
    {
        session_start();
        require_once('vendor/autoload.php');
        
        $this->uri = $_SERVER['REQUEST_URI'];
    
        $dotenv = Dotenv\Dotenv::create(__DIR__);
        $dotenv->load();
        
        foreach (glob(__DIR__ . "/App/Models/*.php") as $key) {
            include($key);
        }

        foreach (glob(__DIR__ . "/App/Controllers/*.php") as $key) {
            include_once($key);
        }
    }

    public function router()
    {
        $tmp = !empty($this->uri) ? $this->uri : 'Teste'; // Página padrão home
        
        $tmp = substr($tmp, 1);
        $tmp = (substr($tmp, -1) === "/") ? header("Location:".substr($tmp, 0, -1)) : $tmp;
        
        $uri = explode('/', $tmp);

        $vars = array(
            'controller'   => (count($uri) > 0 ? array_shift($uri) : 'Teste'),
            'action'       => (count($uri) > 0 ? array_shift($uri) : 'index'),
            'params'       => array()
        );
        foreach ($uri as $val) {
            $vars['params'][] = $val;
        }
        
        $route = 'App\\Controllers\\'.ucfirst($vars['controller']).'::'.$vars['action'];
        
        if (method_exists('\\App\\Controllers\\'.ucfirst($vars['controller']), $vars['action'])) {
            call_user_func($route);
        } else {
            require_once('App\\Views\\404.php');
            die();
        }
    }

    public function run()
    {
        $this->router();
    }
}
