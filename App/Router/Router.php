<?php
/**
 * Created by PhpStorm.
 * User: jowbl
 * Date: 28/05/2019
 * Time: 21:11
 */

namespace App\Router;

class Router
{
    public $routes = [
        '/teste' => [
            'method' => 'GET',
            'action' => 'Teste::index'
        ]
    ];

}