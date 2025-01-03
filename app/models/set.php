<?php

require_once __DIR__."/../config/database.php";
require_once __DIR__."/../models/user.php";

class Set{
    public $id;
    public $name;

    public $private;
    public $author_id;
    public $cards = [];
    public $views;
    

    private $conn;
    public function __construct($id = null, $name = null, $private = null, $author_id=null){
        $this->id = $id;
        $this->name = $name;
        $this->private = $private ? $private : "true";
        $this->author_id = $author_id;
        $this->views = 0;

        $db = new Database();
        $this->conn = $db->connect();  
    
    }

    /**
     * Searches for set by its id and sets all values of class
     * @param mixed $id
     * @return void
     */
    public function find_by_id($id){
        $query = $this->conn->prepare("SELECT * FROM card_sets WHERE id = '$id'");
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result){
            $this->id = $result["id"];
            $this->name = $result["name"];
            $this->private = $result["private"];
            $this->author_id = $result["author_id"];
            $this->views = $result["views"];
            //find cards
            $card_finder = new Card();
            $this->cards = $card_finder->find_by_owner($this->id);
        }
    }

    /**
     * searches for set by its name and sets all values of class
     * @param mixed $name
     * @return void
     */
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
            $this->views = $result["views"];

            //find cards
            $card_finder = new Card();
            $this->cards = $card_finder->find_by_owner($this->id);
        }
        

    }

    /**
     * Add record with this set to database
     * @return void
     */
    public function add(){
        $this->id = uniqid();
        $query = $this->conn->prepare("INSERT INTO card_sets
        (id, name, private, author_id, views) VALUES
        ('$this->id', '$this->name', '$this->private', '$this->author_id', $this->views);");
        $query->execute();
    }

    /**
     * Removes set from database
     * @return void
     */
    public function remove(){
        //delete all cards
        $query = $this->conn->prepare("DELETE FROM cards
        WHERE set_id = '$this->id';");
        $query->execute();

        // delete set
        $query = $this->conn->prepare("DELETE FROM card_sets
        WHERE id = '$this->id';");
        $query->execute();
    }
    /**
     * Updates row entry in database
     * @return void
     */
    public function update(){
        $query = $this->conn->prepare("UPDATE card_sets
        SET name = '$this->name',
            private = '$this->private',
            views = '$this->views'
        WHERE id = '$this->id';");
        $query->execute();
    }

    /**
     * Increasing views count for this set
     * @return void
     */
    public function addView(){
        $this->views += 1;
        $this->update();
    }

    /** 
     * Does not changes the class Set variable
     * @return array with all found public sets
     */
    public function getAllPublicSets(){
        $query = $this->conn->prepare("SELECT * FROM card_sets WHERE private = 'false' ORDER BY views DESC;");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $foundSets = [];
        foreach($result as $r){
            $set = new Set();
            $set->find_by_id($r["id"]);
            array_push($foundSets, $set);
        }
        return $foundSets;
    }

    /** 
     * Does not changes the class Set variable
     * @param mixed $author_id
     * @return array with all found sets by athor id
     */
    public function getSetsByOwner($author_id){
        $query = $this->conn->prepare("SELECT * FROM card_sets WHERE author_id = '$author_id' ORDER BY views DESC;");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $foundSets = [];
        foreach($result as $r){
            $set = new Set();
            $set->find_by_id($r["id"]);
            array_push($foundSets, $set);
        }
        return $foundSets;

    }

    /** 
     * Does not changes the class Set variable
     * @return array with all found sets
     */
    public function getAllSets(){
        $query = $this->conn->prepare("SELECT * FROM card_sets ORDER BY views DESC;");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $foundSets = [];
        foreach($result as $r){
            $set = new Set();
            $set->find_by_id($r["id"]);
            array_push($foundSets, $set);
        }
        return $foundSets;
    }

    /**
     * checks if the set is owned by user with userId
     * @param mixed $userId
     * @return bool
     */
    function isOwnedBy($userId){
        return ($this->author_id == $userId);
    }
}