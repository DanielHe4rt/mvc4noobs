<?php

namespace model;

class Database{
    public static function connect(){
        include("config.php");
        return  new \PDO("mysql:host=".$config['host'].";dbname=".$config['database'],$config['user'],$config['pass']);
    }
}