<?php

require_once __DIR__."/../core/controller.php";

class SetCreator extends Controller{
    public function index($id = null){
       $model = $this->model("set");
       $set = $model->find_by_id($id);

       $this->view("setCreator/index", $set);
    }

    public function create(){

    }

    public function delete(){

    }

    public function update($id = null){

    }

    public function changePropeties($id = null){
    }
}