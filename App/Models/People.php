<?php

namespace App\Models;

class People extends Model
{
    public $table = "peoples";

    public $fillables = [
        'name', 'age'
    ];

    protected $hidden = ['password'];
}
