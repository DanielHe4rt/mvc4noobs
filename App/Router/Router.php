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
        '/' => [
            'method' => 'GET',
            'action' => 'PeopleController::index',
            'rest' => true
        ]
    ];

    public function response(array $data, $httpCode = 200)
    {
        header("HTTP/1.0 ". $httpCode);
        header('Content-type: application/json');
        echo json_encode($data);
        die;
    }

}