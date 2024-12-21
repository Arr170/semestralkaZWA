<?php

require_once __DIR__ . "/../core/controller.php";
require_once __DIR__ . "/../models/set.php";
require_once __DIR__ . "/../models/card.php";

class SetCreator extends Controller
{
    public function index($id = null)
    {

        $this->view("setCreator/index", null);
    }

    public function post()
    {
        if (isset($_COOKIE['user_id'])) {
            // get data from request
            $input_str = file_get_contents("php://input");
            // set posted in request
            $postedSet = json_decode($input_str, true);
            $postedCards = $postedSet["cards"];


            // check if this set already exists
            $id = $postedSet["id"];
            if ($id) { // would not be used
                echo "set already exists, use /update endpoint";
                exit;
            }

            $newSet = new Set(name: $postedSet["name"], 
                                author_id: $_COOKIE["user_id"],
                                private: $postedSet["is_private"]);
            $newSet->add();

            foreach ($postedCards as $card) {
                $newCard = new Card(
                    question: $card["question"],
                    answer: $card["answer"],
                    set_id: $newSet->id
                );
                $newCard->add();
                array_push($newSet->cards, $newCard);
            }

            echo json_encode($newSet);
        }
        else{
            http_response_code(401);
            echo "User needs to be authorized to post sets!";
        }
    }

    public function get($id)
    {
        $getSet = new Set();
        $getSet->find_by_id($id);
        
        if($getSet->private == true){
            $userId = $_COOKIE["user_id"];
            if($getSet->author_id == $userId){
                echo json_encode($getSet);
                exit;
            }
            else{
                http_response_code(401);
                echo "You don't own this set!";
                exit;
            }
        }
        else{
            echo json_encode($getSet);
            exit;
        }
        
    }
    public function delete() {}

    public function update($id = null) {}

    public function changePropeties($id = null) {}

    public function sets($id = null) {}
}
