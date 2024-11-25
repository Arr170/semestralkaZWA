<?php

require __DIR__."/../core/controller.php";

class User extends Controller {
    
    public function index(){
        $this->view("user/index", null);
    }
}