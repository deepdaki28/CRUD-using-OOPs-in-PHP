<?php

class Database{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $db = "person";

    public function __construct(){
        $this->connect();
    }

    public function connect(){
        $this->conn = new mysqli($this->host,$this->user,$this->password,$this->db);
        if($this->conn->connect_error){
            echo "error";
        }
    }
    
}

?>