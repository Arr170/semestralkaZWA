<?php

require __DIR__."/../core/controller.php";

class User extends Controller {
    
    public function index(){
        $this->view("user/index", null);
    }

    public function login(){
        session_start();
        if($_SERVER["REQUEST_METHOD"] !== "POST"){
            echo "bad";
        }
        else{
            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = new UserModel();
            $user->get_by_email($email);
            if($user->email == password_hash($password, PASSWORD_DEFAULT)){
                $_SESSION["user_id"] = $user->id;
            }
        }
    }

    public function logout(){
    }

    public function register(){
        if($_SERVER["REQUEST_METHOD"] !== "POST"){
            echo "bad";
        }
        else{
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = new UserModel(username: $username, email: $email, password: $password);
            $user->add();
        }
    }
}