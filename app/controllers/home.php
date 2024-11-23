<?php

require_once __DIR__."/../core/controller.php";
class Home extends Controller {
    public function index($name = ' ') {
        $this->view('home/index', null);
    }
}