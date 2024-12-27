<?php

require_once __DIR__ . "/../core/controller.php";
require_once __DIR__ . "/../models/set.php";
require_once __DIR__ . "/../models/card.php";
require_once __DIR__ . "/../models/user.php";


class SetCreator extends Controller
{
    public function index($id = null)
    {
        $user = new UserModel();
        if (isset($_COOKIE["user_id"])) {
            $user->getById($_COOKIE["user_id"]);
        }
        if ($user->exists()) {

            $this->view( "setCreator/index", null);

        } else {
            http_response_code(401);
            echo "not authorized!";
            exit;
        }
    }

    public function viewer($id)
    {
        $user = new UserModel();
        if (isset($_COOKIE["user_id"])) {
            $user->getById($_COOKIE["user_id"]);
        } else {
            $user = null;
        }

        $set = new Set();
        $set->find_by_id($id);
        $set->addView();

        $data = [
            "set" => $set,
            "user" => $user
        ];

        $this->view("setCreator/viewer",  $data);
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
                $oldSet = new Set();
                $oldSet->find_by_id($id);
                $oldSet->remove();
            }

            $newSet = new Set(
                name: $postedSet["name"],
                author_id: $_COOKIE["user_id"],
                private: ($postedSet["is_private"])?"true":"false"
            );
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
        } else {
            http_response_code(401);
            echo "User needs to be authorized to post sets!";
        }
    }

    public function get($id)
    {
        $getSet = new Set();
        $getSet->find_by_id($id);

        if ($getSet->private == true) {
            $userId = $_COOKIE["user_id"];
            if ($getSet->author_id == $userId) {
                echo json_encode($getSet);
                exit;
            } else {
                http_response_code(401);
                echo "You don't own this set!";
                exit;
            }
        } else {
            echo json_encode($getSet);
            exit;
        }
    }
    public function delete($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            $user = new UserModel();
            $set = new Set();
            $set->find_by_id($id);
            if (isset($_COOKIE["user_id"])) {
                $user->getById($_COOKIE["user_id"]);
            }
            if ($user->isAdmin() || $set->isOwnedBy($user->id)) {
                $set->remove();
                echo "deleted";
                exit;
            }
            http_response_code(401);
            exit;
        } else {
            echo "bad";
            exit;
        }
    }

    public function changeVisibility($id)
    {
        $user = new UserModel();
        $set = new Set();
        $set->find_by_id($id);
        if (isset($_COOKIE["user_id"])) {
            $user->getById($_COOKIE["user_id"]);
        }
        if ($user->isAdmin() || $set->isOwnedBy($user->id)) {
            $set->private = $set->private == "true" ? "false" : "true";
            $set->update();
            exit;
        }
        http_response_code(401);
        exit;
    }
}
