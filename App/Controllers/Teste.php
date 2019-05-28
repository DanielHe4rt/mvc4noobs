<?php

namespace App\Controllers;

use App\Models\People ;

class Teste {

    public function index(){
        $people = new People();

        $data = $people->find(23);
        var_dump($data->data);
        $data->update(['name' => 'danielhe4rt','dsa' => 1]);
    }


}