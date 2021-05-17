<?php
    $task = $_POST['task'];
        if ($task == '') {
    echo 'Ведите задание';
    exit();
    }
    $dsn = 'mysql:host=localhost;dbname=mydb';
    $pdo = new PDO($dsn, 'root', 'root');

    $sql = 'INSERT INTO tasks(task) VALUES(:task)';
    $query = $pdo->prepare($sql);
    $query->execute(['task' => $task]);

    header('Location: /');
?>