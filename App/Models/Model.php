<?php
namespace App\Models;

class Model {

    public $primaryKey = "id";

    public $id;

    public $table;

    public $fillables = [];

    protected $hidden = [];

    protected $connection;

    public function __construct(){
        $this->connection = new \PDO("mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME'),getenv('DB_USER'),getenv('DB_PASSWORD'));;
        
    }

    public function find(){
        
    }

    public function create(array $data){
        
        foreach($this->fillables as $key => $value){
            echo $key . " = " . $value['name'];         
            if($key != $fillable['name'] && !in_array($key,$this->hidden)){
                unset($data[$key]);
            }
            
        }
        print_r($data);

        foreach($this->fillables as $fillable){                
            if(array_key_exists($fillable['name'],$data)){
                
                echo "achou";
            }
        }

        $pdo_keys  = implode(",",array_keys($data));
        $pdo_params = '';
        foreach($data as $key => $value){
            $pdo_params .= ":" . $key . ",";
        }
        
        $pdo_params = substr($pdo_params,0,-1);

        $query = "INSERT INTO " . $this->table . " (".$pdo_keys.") VALUES (" . $pdo_params . ")";
        try{
            $sql = $this->connection->prepare($query);
            
            foreach($data as $key => $value){
                
                $sql->bindParam(':' . $key,$value);
            }
            $sql->execute();
            
            echo "Foi";
            
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        
    }

    public function update(array $data){

    }

    public function delete(){

    }

}