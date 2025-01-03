<?php

require_once __DIR__."/../config/database.php";

class Card{

    public $id;
    public $question;
    public $question_img_url;
    public $answer;
    public $answer_img_url;
    public $set_id;

    private $conn;
    public function __construct($id = null,
                                $question = null,
                                $question_img_url = null,
                                $answer = null,
                                $answer_img_url = null,
                                $set_id = null){
        $this->id = $id;
        $this->question = $question;
        $this->question_img_url = $question_img_url;
        $this->answer = $answer;
        $this->answer_img_url;
        $this->set_id = $set_id;

        $db = new Database();
        $this->conn = $db->connect();
    }

    /**
     * Searches for card with provided id
     * @param string $id card id
     * @return void
     */
    public function find_by_id($id){
        $query = $this->conn->prepare("SELECT * FROM cards
        WHERE id = '$id';");

        $query->execute();
        $result = $query->fetch((PDO::FETCH_ASSOC));
        if($result){
            $this->id = $result["id"];
            $this->question = $result["question_text"];
            $this->question_img_url = $result["question_img_url"];
            $this->answer = $result["answer_text"];
            $this->answer_img_url = $result["answer_img_url"];
            $this->set_id = $result["set_id"];
        }
    }

    /**
     * Searches for cards with provided set_id
     * @param string $set_id
     * @return array|null found cards
     */
    public function find_by_owner($set_id): array|null {
        $query = $this->conn->prepare("SELECT * FROM cards
        WHERE set_id = '$set_id';");

        $cards_arr = [];

        $query->execute();
        $result = $query->fetchAll((PDO::FETCH_ASSOC));
        if($result){
            foreach($result as $r){
                $new_card = new Card();
                $new_card->find_by_id($r["id"]);
                array_push($cards_arr, $new_card);
            }
            
            return $cards_arr;
        }

        return null;
    }

    /**
     * Adds card to database
     * @return void
     */
    public function add(){
        if(!$this->id){
            $this->id = uniqid();
            $query = $this->conn->prepare("INSERT INTO cards
            (id, question_text, question_img_url, answer_text, answer_img_url, set_id) VALUES
            ('$this->id', '$this->question', '$this->question_img_url', '$this->answer', '$this->answer_img_url', '$this->set_id');");
            $query->execute();

        }
    }

    /**
     * Updase row entry in database with card values
     * @return void
     */
    public function update(){
        if($this->id){
            $query = $this->conn->prepare("UPDATE cards
            SET question_text = '$this->question',
                question_img_url = '$this->question_img_url',
                answer_text = '$this->answer',
                answer_img_url = '$this->answer_img_url'
            WHERE id = '$this->id';");

            $query->execute();
        }
    }

    /**
     * Removes card from database
     * @return void
     */
    public function remove(){
        if($this->id){
            $query = $this->conn->prepare("DELETE FROM cards
            WHERE id = '$this->id';");
            $query->execute();
        }
    }

    
}