<?php

require_once __DIR__."/../core/controller.php";

class SetCreator extends Controller{
    public function index($id = null){
       $model = $this->model("set");
       $set = $model->find_by_id($id);

       $this->view("setCreator/index", $set);
    }

    public function post(){
        $input_str = file_get_contents("php://input");
        $set = json_decode($input_str,true);
        $cards = $set["cards"];
        foreach($cards as $card){
            print_r((array)$card);
        }
    }

    public function delete(){

    }

    public function update($id = null){

    }

    public function changePropeties($id = null){
    }

    public function sets( $id = null){

    }
}