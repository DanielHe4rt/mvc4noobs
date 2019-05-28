<?php

namespace App\Controllers;


class Controller {

    public function response(array $data, int $httpCode = 200){
        header("HTTP/1.0 ". $httpCode);
        header('Content-type: application/json');
        echo json_encode($data);
    }
}