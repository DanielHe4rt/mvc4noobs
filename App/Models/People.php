<?php

namespace App\Models;

class People extends Model {

    public $table = "peoples";

    public $fillables = [
        ['name' => 'name','required' => true],
        ['name' => 'age','required' => true],
        ['name' => 'password','required' => false]
    ];

    protected $hidden = ['password'];

}