<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\People;

class Teste extends Controller
{
    public function index()
    {
        $people = new People();
        $data = $people->create(['name' => 'danielhe4rt123123', 'age' => 213, 'password' => 'qualquermerda']);
        parent::response($data->data);
    }
}
