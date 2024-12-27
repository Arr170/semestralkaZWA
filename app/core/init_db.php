<?php

require "../config/database.php";

try{
    $db = new Database();
    $conn = $db->connect();

    echo "[1] database created\n";


    // user table 
    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        id TEXT PRIMARY KEY,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        password TEXT NOT NULL, 
        role TEXT   
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
    $adminId = uniqid();
    // yes, very secure password
    $adminPass = password_hash("123456789", PASSWORD_DEFAULT);
    $query = $conn->prepare("INSERT INTO users
    (id, name, email, password, role) VALUES
    ('$adminId', 'admin1', 'admin@admin.admin', '$adminPass', 'admin');");

    $query->execute();

    echo "[3] initial admin inserted\n";
}catch(PDOException $e){
    die("[xxx] Error initializing database: ".$e->getMessage());
}