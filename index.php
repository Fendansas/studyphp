<?php

include 'configdb.php';
$route = $_GET['route'];
require 'view/header.php';
if($route ==''){
    require 'view/create.php';
}
switch ($route){
    case 'main':
        require 'view/main.php';
        break;
    case 'list':
        require 'list.php';
        break;

}



//$dsn = 'mysql:host=localhost;dbname=mydb';
//$pdo = new PDO($dsn, 'root', 'root');
//$sql = "SELECT FROM test";
//$statement = $pdo->prepare($sql);
//$statement->execute();
//$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
//
//include "view/main.php";
//var_dump($posts);