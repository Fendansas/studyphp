<?php
include 'configdb.php';

function uploadImage($image)
{
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . "." . $extension;
    move_uploaded_file($image['tmp_name'], "uploads/".$filename);
    return $filename;
}

function addPost($title, $content, $filename){
    $dsn = 'mysql:host=localhost;dbname=mydb';
    $pdo = new PDO($dsn, 'root', 'root');
    $sql = "INSERT INTO test (title, content, image) VALUES (:title, :content, :image)";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(":title", $title);
    $statement->bindParam(":content", $content);
    $statement->bindParam("image", $filename);
    $statement->execute();
}

