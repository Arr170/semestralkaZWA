<?php

class Controller{
    protected function model($model){
        require_once __DIR__.'/../models/' . $model . '.php';

        return new $model();

    }

    public function view($view, $data){

        require_once __DIR__ .'/../views/' . $view . '.php';
    }
}

function log_($message)
{
    $message = date("H:i:s") . " - $message - ".PHP_EOL;
    print($message);
    flush();
    ob_flush();
}