<?php

include("database.php");

class Person{
    private $conn;

    public function __construct(){
        $database = new Database();
        $this->conn = $database->conn;
    }

    public function create($name,$email,$age){
        $insert = $this->conn->prepare("INSERT INTO details (name,email,age) VALUES (?,?,?)");
        $insert->bind_param("ssi",$name,$email,$age);
        return $insert->execute();
    }

    public function read(){
        $select = $this->conn->prepare("SELECT * FROM details");
        $select->execute();
        $result = $select->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function update($id,$name,$email,$age){
        $update = $this->conn->prepare("UPDATE details SET name =?, email=?, age=? WHERE id=?");
        $update->bind_param("ssii",$name,$email,$age,$id);
        return $update->execute();
    }

    public function delete($id){
        $delete = $this->conn->prepare("DELETE FROM details WHERE id=?");
        $delete->bind_param("i",$id);
        return $delete->execute();
    }

}


?>