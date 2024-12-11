<?php

require __DIR__ . "/../core/controller.php";
require __DIR__ . "/../models/user.php";

class User extends Controller
{

    public function index()
    {
        $this->view("user/index", null);
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
            $user->get_by_email($email);
            if (password_verify($password,  $user->password)) {
                $_SESSION["user_id"] = $user->id;
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
                    "mail" => $email,
                    "pass u" => $user->password,
                    "pass c" => $password
                ];
                http_response_code(401);
                echo json_encode($data);
            }
        }
    }

    public function logout() {}

    public function signup()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo "bad";
        } else {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = new UserModel();
            $user->get_by_email($email);
            if ($user->id) {
                $data = (object)[];
                $data->status =  "bad";
                $data->message = "User with this email already exists!";
                $data->id = $user->id;
                $data->email = $email;
                $data->umail = $user->email;

                http_response_code(409);

                echo json_encode($data);
                exit();
            } else {

                $user = new UserModel($username,  $email, $password);
                $user->add();
                $_SESSION["user_id"] = $user->id;
                $data = [
                    "status" => "ok",
                    "message" => "User created"

                ];

                http_response_code(201);

                echo json_encode($data);
            }
        }
    }
}
