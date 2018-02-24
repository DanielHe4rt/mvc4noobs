<?php
    
    session_start();
    foreach(glob("controller/*.php") as $key){
        include_once($key);
    }
    foreach(glob("model/*.php") as $key){
        include($key);
    }

    use \controller as controller;
    use \model as model;
    
    
    $tmp = !empty($_GET['uri']) ? $_GET['uri'] : 'principal'; // Página padrão home
    
    $uri = explode('/', $tmp);
    
    $vars = array(
        'controller'   => (count($uri) > 0 ? array_shift($uri) : 'index'),
        'action'       => (count($uri) > 0 ? array_shift($uri) : 'index'),
        'params'       => array()
    );
    
    $key = NULL;
    if (count($uri) > 1){
        foreach ($uri as $val) {
            if (is_null($key))
                $key = $val;
            else {
                $vars['params'][$key] = $val;
                $key = NULL;
            }
        }
    }
    $rota = 'controller\\'.ucfirst($vars['controller']).'::'.$vars['action'];
    
    if(method_exists('controller\\'.ucfirst($vars['controller']),$vars['action'])){
        call_user_func($rota); 
    }
?>