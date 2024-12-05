<?php

require "../config/database.php";

try{
    $db = new Database();
    $conn = $db->connect();
    // $conn = new PDO("mysql:host={$config['host']};port={$config['port']}", 
    //                 $config['username'], $config['password']);

    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //$conn->exec("CREATE DATABASE IF NOT EXISTS flashcards;");
    echo "[1] database created\n";

    //$conn->exec("USE flashcards");

    // admins table
    $conn->exec("CREATE TABLE IF NOT EXISTS admins (
        id TEXT PRIMARY KEY, 
        name TEXT NOT NULL,
        password TEXT NOT NULL 
    );");

    // user table 
    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        id TEXT PRIMARY KEY,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        password TEXT NOT NULL    
    );");

    // card set table
    $conn->exec("CREATE TABLE IF NOT EXISTS card_sets(
        id TEXT PRIMARY KEY,
        author_id TEXT NOT NULL,
        name TEXT NOT NULL,
        private BOOLEAN NOT NULL,
        FOREIGN KEY (author_id) REFERENCES users(id)

    );");

    // card table
    $conn->exec("CREATE TABLE IF NOT EXISTS cards(
        id TEXT PRIMARY KEY,
        set_id TEXT NOT NULL,
        question_text TEXT, 
        answer_text TEXT,
        question_img_url TEXT,
        answer_img_url TEXT,
        FOREIGN KEY (set_id) REFERENCES card_sets(id)
    );");

    

    echo "[2] tables created\n";

    // initial data - admin
    $conn->exec("INSERT INTO admins (name, password) VALUES ('admin', '12345678');");

    echo "[3] initial admin inserted\n";
}catch(PDOException $e){
    die("[xxx] Error initializing database: ".$e->getMessage());
}