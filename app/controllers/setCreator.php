<?php

require_once __DIR__ . "/../core/controller.php";
require_once __DIR__ . "/../models/set.php";
require_once __DIR__ . "/../models/card.php";
require_once __DIR__ . "/../models/user.php";


/**
 * Controlls sets creation and views
 */
class SetCreator extends Controller
{
    /**
     * renders set editor page
     * @param string $id set id
     * @return void
     */
    public function index($id = null)
    {
        $user = new UserModel();
        if (isset($_COOKIE["user_id"])) {
            $user->getById($_COOKIE["user_id"]);
        }
        if ($user->exists()) {

            $this->view("setCreator/index", null);
        } else {
            http_response_code(401);
            echo "not authorized!";
            exit;
        }
    }

    /**
     * renders set viewer page
     * @param string $id set id
     * @return void
     */
    public function viewer($id)
    {
        $user = new UserModel();
        if (isset($_COOKIE["user_id"])) {
            $user->getById($_COOKIE["user_id"]);
        }

        $set = new Set();
        $set->find_by_id($id);
        $set->addView();

        $data = [
            "setId" => $set->id,
            "owner" => $set->isOwnedBy($user->id),
        ];

        $this->view("setCreator/viewer",  $data);
    }

    /**
     * Creates new set in database ano first card.
     * Respondes JSON with set
     * only for logged in users
     * @return void
     */
    public function initSet()
    {
        $user = new UserModel();
        if (isset($_COOKIE['user_id'])) {
            $user->getById($_COOKIE["user_id"]);
        }
        if ($user->exists()) {
            $initSet = new Set(author_id: $user->id, name: "new set");
            $initSet->add();

            $initCard = new Card(set_id: $initSet->id);
            $initCard->add();

            array_push($initSet->cards, $initCard);

            http_response_code(201);
            echo json_encode($initSet);
        } else {
            http_response_code(401);
            echo "User needs to be authorized to post sets!";
        }
    }

    /**
     * Respondes JSON with requested set
     * For owners of private set, for every user for public set
     * @param string $id set id
     * @return never
     */
    public function get($id)
    {
        $getSet = new Set();
        $getSet->find_by_id($id);

        if ($getSet->private == "true") {
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

    /**
     * Deletes set with requested id
     * For owners of set or admin
     * @param string $id set id
     * @return never
     */
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

    /**
     * Deletes card with requested id
     * For owners of set
     * @param string $id card id
     * @return never
     */
    public function deleteCard($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            $user = new UserModel();
            $card = new Card();
            $card->find_by_id($id);
            $set = new Set();
            $set->find_by_id($card->set_id);

            if (isset($_COOKIE["user_id"])) {
                $user->getById($_COOKIE["user_id"]);
            }

            if ($user->exists() && $set->isOwnedBy($user->id)) {
                $card->remove();
                echo "deleted";
                exit;
            } else {
                http_response_code(401);
                exit;
            }
        } else {
            echo "bad";
            exit;
        }
    }

    /**
     * Updates is_private property of set, value passed in POST request
     * key: "isPrivate"
     * For owner of requested set
     * @param string $id set id
     * @return never
     */
    public function updateSetPrivate($id)
    {
        $user = new UserModel();
        $set = new Set();
        $set->find_by_id($id);


        $input_str = file_get_contents("php://input");
        $data = json_decode($input_str, true);

        if (isset($_COOKIE["user_id"])) {
            $user->getById($_COOKIE["user_id"]);
        }
        if ($user->isAdmin() || $set->isOwnedBy($user->id)) {
            $set->private = $data["isPrivate"] ? "true" : "false";
            $set->update();
            http_response_code(200);
            echo json_encode($set);
            exit;
        }
        http_response_code(401);
        exit;
    }

    /**
     * Updates set name of requested set
     * key: "newName"
     * For owner of requested set
     * @param string $id set id
     * @return never
     */
    public function updateSetName($id)
    {
        $user = new UserModel();
        $set = new Set();
        $set->find_by_id($id);


        $input_str = file_get_contents("php://input");
        $data = json_decode($input_str, true);

        if (isset($_COOKIE["user_id"])) {
            $user->getById($_COOKIE["user_id"]);

            if ($user->isAdmin() || $set->isOwnedBy($user->id)) {
                $set->name = substr($data["newName"], 0, 20);
                $set->update();
                http_response_code(201);
                exit;
            } else {
                http_response_code(401);
                exit;
            }
        } else {
            http_response_code(401);
            exit;
        }
    }

    /**
     * Updates card text of requested card
     * keys: 
     * -"setId" of parent set
     * -"id" card id
     * -"side" side of card to update
     * -"text" text to insert into card      
     * For owner of requested card
     * @param string $id card id
     * @return never
     */
    public function updateCardText($id)
    {
        $input_str = file_get_contents("php://input");
        $data = json_decode($input_str, true);

        $user = new UserModel();
        $card = new Card();
        $set = new Set();

        if (isset($_COOKIE["user_id"])) {
            $user->getById($_COOKIE["user_id"]);
            $set->find_by_id($data["setId"]);
            $card->find_by_id($data["id"]);
            if ($user->exists() && $set->isOwnedBy($user->id)) {
                if ($data["side"] == "front") {
                    $card->question = $data["text"];
                } else {
                    $card->answer = $data["text"];
                }
                $card->update();
                echo json_encode($set);
                exit;
            } else {
                http_response_code(401);
                exit;
            }
        } else {
            http_response_code(401);
            exit;
        }
    }

    /**
     * Creates new card and places it in set with $setId
     * For owner of set
     * Respondes JSON with new card
     * @param string $setId
     * @return never
     */
    public function newCard($setId)
    {
        $user = new UserModel();

        if (isset($_COOKIE["user_id"])) {
            $user->getById($_COOKIE["user_id"]);
            if ($user->exists()) {

                $newCard = new Card(set_id: $setId);
                $newCard->add();

                echo json_encode($newCard);
                http_response_code(201);
                exit;
            } else {
                http_response_code(401);
                exit;
            }
        } else {
            http_response_code(401);
            exit;
        }
    }

    /**
     * Updated image of card 
     * For owner of card
     * Respondes with updated card
     * keys:
     * -"image" file with uploaded image
     * -"setId" id of set to update
     * -"cardId" id of card to update
     * @param string $id
     * @return void
     */
    public function updateCardImg($id)
    {
        $card_info_str = $_POST["cardInfo"] ?? null;
        if (!$card_info_str) {
            echo "card info null";
        }
        $card_info = json_decode($card_info_str, true);

        $user = new UserModel();
        $card = new Card();
        $set = new Set();

        if (isset($_COOKIE["user_id"])) {
            $user->getById($_COOKIE["user_id"]);
            $set->find_by_id($card_info["setId"]);
            $card->find_by_id($card_info["cardId"]);
            if ($user->exists() && $set->isOwnedBy($user->id)) {
                if (isset($_FILES["image"])) {
                    $img = [
                        'name' => $_FILES["image"]["name"],
                        'type' => $_FILES["image"]["type"],
                        'tmp_name' => $_FILES["image"]["tmp_name"],
                        'error' => $_FILES["image"]["error"],
                        'size' => $_FILES["image"]["size"],
                    ];


                    try {
                        $saved_img = saveImg($img, $set->id);
                        if ($card_info["cardSide"] == "front") {
                            $card->question_img_url = $saved_img;
                        } else {
                            $card->answer_img_url = $saved_img;
                        }
                    } catch (Exception $e) {
                        echo "Error saving question image: " . $e->getMessage() . "\n";
                        http_response_code(500);
                        echo "Error while saving image.";
                    }
                    $card->update();
                    echo json_encode($card);
                    exit;
                }
            } else {
                http_response_code(401);
                echo $card_info_str;
                exit;
            }
        } else {
            http_response_code(401);
            echo $card_info_str;
            exit;
        }
    }

    /**
     * Respondes with image for provided path
     * For owner of private set or all user for public set
     * @param mixed $imagePath
     * @return never
     */
    public function serveImg($imagePath)
    {

        $user = new UserModel();
        if (isset($_COOKIE['user_id'])) {
            $user->getById($_COOKIE["user_id"]);
        }
        $ids = explode("_", $imagePath);
        $set = new Set();
        $set->find_by_id($ids[1]);

        $img_path = BASE_PATH . '/uploads/' . $imagePath;

        if (file_exists($img_path)) {
            if ($set->isOwnedBy($user->id) || $set->private == "false") {
                $mimeType = mime_content_type($img_path);
                header('Content-Type: ' . $mimeType);
                header('Content-Length: ' . filesize($img_path));
                readfile($img_path);
                exit;
            } else {
                http_response_code(401);
                echo "Access denied." . $set->private;
                exit;
            }
        } else {
            http_response_code(404);
            echo "File not found.";
            exit;
        }
    }
}

/**
 * Saves image in /upload/ folder
 * For owner of updated set
 * @param mixed $file image to save
 * @param string $set_id id of updated set
 * @throws \Exception in every error
 * @return string name of saved image file
 */
function saveImg($file,  $set_id)
{
    $uploadDirectory = BASE_PATH . '/uploads/';
    
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $allowedTypes = ['image/jpeg', 'image/png'];
    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception("Invalid file type: " . $file['type']);
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("File upload error: " . $file['error']);
    }

    $uniqueFileName = uniqid() . '_' . $set_id;
    $filePath = $uploadDirectory . $uniqueFileName;

    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        throw new Exception("Failed to move uploaded file.");
    }

    return $uniqueFileName;
}
