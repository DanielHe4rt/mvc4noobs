<?php

namespace controller;

class Principal{
    public function index(){
        require("view/inicio.php");
        $teste = new \model\Teste();
        $teste->greetz("Daniel");
    }
}