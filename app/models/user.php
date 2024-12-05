<?php

require __DIR__."../config/database.php";
require __DIR__."../models/user.php";

class UserModel{

    public $id;
    public $username;
    public $email;
    public $password;

    private $conn;
    
    function __construct($username = null, $email = null, $password = null){
        $this->id = uniqid();
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $db = new Database();
        $this->conn = $db->connect();
    }

    function get_by_id($id){
        $query = $this->conn->prepare("SELECT * FROM users WHERE id = $id");
        $query->execute();
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        echo $result;        
        //finish this function
    }   

    function get_by_email( $email ){
        $query = $this->conn->prepare("SELECT * FROM users WHERE email = $email");
        $query->execute();
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
        echo $result;
        if($result){
            $this->id = $result["id"];
            $this->username = $result["username"];  
            $this->email = $result["email"];
        }
    }

    function add(){
        $query = $this->conn->prepare("INSERT INTO users 
        (id, name, email, password) VALUES ($this->id, $this->username, $this->email, $this->password);");
    
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
    }

    function update(){
        
    }
}