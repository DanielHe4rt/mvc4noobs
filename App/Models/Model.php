<?php
namespace App\Models;

class Model {

    public $primaryKey = "id";

    public $id;

    public $table;

    public $fillables = [];

    public $data;

    protected $hidden = [];

    protected $connection;

    public function __construct(){
        try{
            $this->connection = new \PDO("mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME'),getenv('DB_USER'),getenv('DB_PASSWORD'));
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $e){
            return $this->response(['error' => $e->getMessage()]);
        }
    }

    public function find(int $id){
        try{
            $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
            $result = $this->connection->prepare($query);
            $result->bindParam(':id', $id);
            $result->execute();
            
            $this->data = $result->fetch(\PDO::FETCH_ASSOC);
            if(!isset($this->data)){
                return false;
            }
            foreach($this->hidden as $value){
                unset($this->data[$value]);
            }

            $this->id = $this->data['id'];
            return $this;
            
            
            
            
        }catch(\PDOException $e){
            die($e->getMessage());
        }
    }

    public function create(array $data){
        
        foreach($data as $key => $value){
            if(!in_array($key,$this->fillables) && !in_array($key,$this->hidden)){
                unset($data[$key]);
            }
        }
        
        $pdo_keys  = implode(",",$this->fillables);
        $pdo_keys .= count($this->hidden) > 0 ? "," . implode(',',$this->hidden) : null;
        $pdo_params = '';

        foreach($this->fillables as $value){
            $pdo_params .= ":" . $value . ",";
        }

        foreach($this->hidden as $value){
            $pdo_params .= ":" . $value . ",";
        }
        
        $pdo_params = substr($pdo_params,0,-1);

        $query = "INSERT INTO " . $this->table . " (".$pdo_keys.") VALUES (" . $pdo_params . ")";
        
        try{
            $sql = $this->connection->prepare($query);
            
            foreach($this->fillables as &$key){
                $sql->bindParam(':' . $key, $data[$key]);
            }

            foreach($this->hidden as &$key){
                $sql->bindParam(':' . $key, $data[$key]);
            }

            $sql->execute();
            $this->id = $this->connection->lastInsertId();
            $this->find($this->id);
            return $this;
            
        }catch(\PDOException $e){
            return $this->response(['error' => $e->getMessage()]);
        }
        
    }

    public function update(array $data){
        foreach($data as $key => $value){
            if(!in_array($key,$this->fillables) && !in_array($key,$this->hidden)){
                unset($data[$key]);
            }
        }
        if(count($data) == 0){
            die('Nenhum parametro correspondente a classe informado.');
        }
        
        $pdo_data = '';
        foreach($data as $key => $value){
            $pdo_data .= $key . " = :" . $key . ", "; 
        }

        $pdo_data = substr($pdo_data,0,-2);

        try{
            $query = "UPDATE " . $this->table . " SET " . $pdo_data . " WHERE id = :id";
            
            $sql = $this->connection->prepare($query);
            $sql->bindParam(':id', $this->id);
            
            foreach($data as $key => &$value){
                $sql->bindParam(':' . $key, $value);
            }

            $sql->execute();
            
            $this->find($this->id);
            return $this;
            
        }catch(\PDOException $e){
            return $this->response(['error' => $e->getMessage()]);
        }
    }

    public function delete(int $id = null){
        $id = $id ?: $this->id;
        try{
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $result = $this->connection->prepare($query);
            $result->bindParam(':id', $id);

            return $result->execute();
            
        }catch(\PDOException $e){
            return $this->response(['error' => $e->getMessage()]);
        }

    }

    public function response(array $data, int $httpCode = 200){
        header("HTTP/1.0 ". $httpCode);
        header('Content-type: application/json');
        die(json_encode($data));
    }

}