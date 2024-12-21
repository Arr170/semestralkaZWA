<?php

require_once __DIR__."/../config/database.php";
require_once __DIR__."/../models/user.php";

class Set{
    public $id;
    public $name;

    public $private;
    public $author_id;
    public $cards = [];

    private $conn;
    public function __construct($id = null, $name = null, $private = null, $author_id=null){
        $this->id = $id;
        $this->name = $name;
        $this->private = $private;
        $this->author_id = $author_id;

        $db = new Database();
        $this->conn = $db->connect();
    
    }

    public function find_by_id($id){
        $query = $this->conn->prepare("SELECT * FROM card_sets WHERE id = '$id'");
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result){
            $this->id = $result["id"];
            $this->name = $result["name"];
            $this->private = $result["private"];
            $this->author_id = $result["author_id"];
            //find cards
            $card_finder = new Card();
            $this->cards = $card_finder->find_by_owner($this->id);
        }
    }

    public function find_by_name($name){
        // find the set
        $query = $this->conn->prepare("SELECT * FROM card_sets WHERE name = '$name';");
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result){
            $this->id = $result["id"];
            $this->name = $result["name"];
            $this->private = $result["private"];
            $this->author_id = $result["author_id"];
            //find cards
            $card_finder = new Card();
            $this->cards = $card_finder->find_by_owner($this->id);
        }
        

    }
    public function add(){
        $this->id = uniqid();
        $query = $this->conn->prepare("INSERT INTO card_sets
        (id, name, private, author_id) VALUES
        ('$this->id', '$this->name', '$this->private', '$this->author_id');");
        $query->execute();
    }

    public function remove($id){
        //delete all cards
        $query = $this->conn->prepare("DELETE FROM cards
        WHERE set_id = '$id';");
        $query->execute();

        // delete set
        $query = $this->conn->prepare("DELETE FROM card_sets
        WHERE id = '$id';");
        $query->execute();
    }
    public function update(){
    }
}