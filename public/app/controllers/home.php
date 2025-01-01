<?php

require_once __DIR__."/../core/controller.php";
require_once __DIR__ . "/../models/set.php";
require_once __DIR__ . "/../models/card.php";
class Home extends Controller {
    public function index($name = ' ') {
        $setManager = new Set();
        $foundSets = $setManager->getAllPublicSets();

        $this->view('home/index', $foundSets);
    }
}