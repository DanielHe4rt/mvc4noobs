<?php

use App\Router\Router as Router;

class Application
{

    public $uri;
    public $method;
    public $router;


    public function __construct()
    {
        session_start();
        require_once('vendor/autoload.php');
        require_once('App/Router/Router.php');

        $this->router = new Router();

        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];

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
        if (isset($this->router->routes[$this->uri])) {

            $routeData = $this->router->routes[$this->uri];

            $uri = explode('::', $routeData['action']);
            $vars = array(
                'controller' => (count($uri) > 0 ? array_shift($uri) : 'index'),
                'action' => (count($uri) > 0 ? array_shift($uri) : 'index'),
                'params' => array()
            );

            $route = 'App\\Controllers\\' . ucfirst($vars['controller']) . '::' . $vars['action'];

            if (method_exists('\\App\\Controllers\\' . ucfirst($vars['controller']), $vars['action'])) {
                $response = call_user_func($route);
                if ($routeData['rest']) {
                    $this->router->response($response);
                }
                echo $response;

            } else {
                require_once('App\\Views\\methodNotFound.php');
                die();
            }

        } else {
            require_once('App\\Views\\routeNotFound.php');
            die();
        }
    }

    public function run()
    {
        $this->router();
    }
}
