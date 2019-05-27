<?php

namespace App\Controllers;

use App\Models\People ;

class Teste {

    public function index(){
        $teste = new People();

        $teste->create(['name' => '','password' => 'teste', 'age' => 2]);
    }


}