<?php

require_once __DIR__ . "/../core/controller.php";
require_once __DIR__ . "/../models/user.php";
require_once __DIR__ . "/../models/set.php";
require_once __DIR__ . "/../models/card.php";

class User extends Controller
{

    public function index()
    {
        if (isset($_COOKIE["user_id"])) {
            $setManager = new Set();
            $foundSets = $setManager->getSetsByOwner($_COOKIE["user_id"]);
            $user = new UserModel();
            $user->getById($_COOKIE["user_id"]);
            $data = [
                "sets" => $foundSets,
                "username" => $user->username
            ];

            $this->view("user/index", $data);
        } else {
            http_response_code(401);
            echo "Not authorized!";
            exit;
        }
    }

    public function admin()
    {
        if (isset($_COOKIE["user_id"]) && isset($_COOKIE["user_role"]) && $_COOKIE["user_role"] == "admin") {
            $setManager = new Set();
            $userManager = new UserModel();

            $foundSets =  $setManager->getAllSets();
            $foundUsers = $userManager->getAll();
            $data = ["sets" => $foundSets, "users" => $foundUsers];

            $this->view("user/admin", $data);
        } else {
            http_response_code(401);
            echo "Not authorized!";
            exit;
        }
    }
    public function login()
    {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo "bad";
        } else {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = new UserModel();
            $user->getByEmail($email);
            if (password_verify($password,  $user->password)) {
                setcookie("user_id", $user->id, time() + 3600 * 24, "/");
                setcookie("user_role", $user->role, time() + 3600 * 24, "/");

                $data = [
                    "status" => "ok",
                    "message" => "Logged in!",
                ];

                http_response_code(200);
                echo json_encode($data);
            } else {
                $data = [
                    "status" => "bad",
                    "message" => "Incorrect e-mail or password!",
                ];
                http_response_code(401);
                echo json_encode($data);
            }
        }
    }

    public function logout()
    {

        setcookie("user_id", "", time() - 3600, "/");
        setcookie("user_role",  "", time() - 3600, "/");
        $data = [
            "status" => "ok",
            "message" => "logged out"
        ];

        echo (json_encode($data));
    }

    public function signup()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo "bad";
        } else {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];



            $user = new UserModel();
            $user->getByEmail($email);
            if ($user->id) {
                $data = (object)[];
                $data->status =  "bad";
                $data->message = "User with this email already exists!";

                http_response_code(409);

                echo json_encode($data);
                exit();
            } else if (!validatePassword($password)) {
                $data = (object)[];
                $data->status =  "bad";
                $data->message = "Wrong password format!";

                http_response_code(409);

                echo json_encode($data);
                exit();
            } else {

                $user = new UserModel($username,  $email, $password);
                $user->add();
                setcookie("user_id", $user->id, time() + 3600 * 24, "/");
                setcookie("user_role", $user->role, time() + 3600 * 24, "/");
                $data = [
                    "status" => "ok",
                    "message" => "User created"
                ];

                http_response_code(201);

                echo json_encode($data);
            }
        }
    }

    public function delete($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            $user = new UserModel();
            if (isset($_COOKIE["user_id"])) {
                $user->getById($_COOKIE["user_id"]);
            }
            if ($user->isAdmin()) {
                $userToRemove = new UserModel();
                $userToRemove->getById($id);
                $userToRemove->remove();
                echo "removed";
                exit;
            } else {
                http_response_code(401);
                echo "not an admin";
                echo json_encode($user);
                exit;
            }
        } else {
            echo "bad";
            exit;
        }
    }
}


function validatePassword($password)
{
    $minLen = 8;
    $containsNumber = preg_match('/\d/', $password);
    $containsLetter = preg_match('/[a-zA-Z]/', $password);

    return strlen($password) >= $minLen && $containsNumber && $containsLetter;
}
