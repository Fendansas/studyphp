<?php

$dsn = 'mysql:host=localhost;dbname=mydb';
$pdo = new PDO($dsn, 'root', 'root');

$id = $_GET['id'];

$sql = 'UPDATE tasks SET scores WHERE `id` = ?';
$query = $pdo->prepare($sql);
$query->execute([$id]);

header('Location: /');
?>