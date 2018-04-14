<?php
    session_start();
    include("config-env.php");
    use \controller as controller;
    use \model as classes;    
    foreach(glob("controller/*.php") as $key){
        include_once($key);
    }
    foreach(glob("model/*.php") as $key){
        include($key);
    }
    
    $tmp = !empty($_GET['uri']) ? $_GET['uri'] : 'login'; // Página padrão home
    $tmp = (substr($tmp,-1) === "/") ? header("Location:".substr($tmp,0,-1)) : $tmp;
    $uri = explode('/', $tmp);
    
    $vars = array(
        'controller'   => (count($uri) > 0 ? array_shift($uri) : 'index'),
        'action'       => (count($uri) > 0 ? array_shift($uri) : 'index'),
        'params'       => array()
    );
    foreach($uri as $val){
        $vars['params'][] = $val;
    }

    $rota = 'controller\\'.ucfirst($vars['controller']).'::'.$vars['action'];
    
    if(method_exists('controller\\'.ucfirst($vars['controller']),$vars['action'])){
        $_GET['params'] = $vars['params']; 
        call_user_func($rota); 
    }   

    
?>